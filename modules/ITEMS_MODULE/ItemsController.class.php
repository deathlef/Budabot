<?php

namespace Budabot\User\Modules;

use Exception;
use stdClass;
use DOMDocument;

/**
 * @Instance
 *
 * Commands this controller contains:
 *	@DefineCommand(
 *		command     = 'items',
 *		accessLevel = 'all',
 *		description = 'Searches for an item using the default items db',
 *		help        = 'items.txt',
 *		alias		= 'i'
 *	)
 *	@DefineCommand(
 *		command     = 'itemid',
 *		accessLevel = 'all',
 *		description = 'Searches for an item by id',
 *		help        = 'items.txt'
 *	)
 *	@DefineCommand(
 *		command     = 'updateitems',
 *		accessLevel = 'guild',
 *		description = 'Downloads the latest version of the items db',
 *		help        = 'updateitems.txt'
 *	)
 */
class ItemsController {
	
	public $moduleName;

	/** @Inject */
	public $db;

	/** @Inject */
	public $chatBot;

	/** @Inject */
	public $http;

	/** @Inject */
	public $settingManager;

	/** @Inject */
	public $text;
	
	/** @Inject */
	public $util;
	
	/** @Logger */
	public $logger;

	/** @Setup */
	public function setup() {
		$this->db->loadSQLFile($this->moduleName, "aodb");
		
		$this->settingManager->add($this->moduleName, 'maxitems', 'Number of items shown on the list', 'edit', 'number', '40', '30;40;50;60');
	}

	/**
	 * @HandlesCommand("items")
	 * @Matches("/^items ([0-9]+) (.+)$/i")
	 * @Matches("/^items (.+)$/i")
	 */
	public function itemsCommand($message, $channel, $sender, $sendto, $args) {
		$msg = $this->findItems($args);
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("itemid")
	 * @Matches("/^itemid ([0-9]+)$/i")
	 */
	public function itemIdCommand($message, $channel, $sender, $sendto, $args) {
		$id = $args[1];

		$row = $this->findById($id);
		if ($row === null) {
			$msg = "No item found with id <highlight>$id<end>.";
		} else {
			$blob = print_r($row, true);
			$blob .= "\n\n" . $this->formatSearchResults(array($row), null, true);
			$msg = $this->text->makeBlob($id, $blob);
		}

		$sendto->reply($msg);
	}
	
	public function findById($id) {
		$sql = "SELECT * FROM aodb WHERE highid = ? UNION SELECT * FROM aodb WHERE lowid = ? LIMIT 1";
		return $this->db->queryRow($sql, $id, $id);
	}

	/**
	 * @HandlesCommand("updateitems")
	 * @Matches("/^updateitems$/i")
	 */
	public function updateitemsCommand($message, $channel, $sender, $sendto) {
		$msg = $this->downloadNewestItemsdb();
		$sendto->reply($msg);
	}

	/**
	 * @Event("timer(7days)")
	 * @Description("Check to make sure items db is the latest version available")
	 */
	public function checkForUpdate() {
		$msg = $this->downloadNewestItemsdb();
		if (preg_match("/^The items database has been updated/", $msg)) {
			$this->chatBot->sendGuild($msg);
		}
	}

	public function downloadNewestItemsdb() {
		$this->logger->log('DEBUG', "Starting items db update");

		// get list of files in ITEMS_MODULE
		$response = $this->http
			->get("https://api.github.com/repos/Budabot/Budabot/contents/modules/ITEMS_MODULE")
			->withHeader("Accept", "application/vnd.github.v3+json")
			->withHeader('User-Agent', 'Budabot')
			->waitAndReturnResponse();

		try {
			$json = json_decode($response->body);
		
			// find the latest items db version on the server
			$latestVersion = null;
			forEach ($json as $item) {
				if (preg_match("/^aodb(.*)\\.sql$/i", $item->name, $arr)) {
					if ($latestVersion === null) {
						$latestVersion = $arr[1];
					} else if ($this->util->compareVersionNumbers($arr[1], $currentVersion)) {
						$latestVersion = $arr[1];
					}
				}
			}
		} catch (Exception $e) {
			$msg = "Error updating items db: " . $e->getMessage();
			$this->logger->log('ERROR', $msg);
			return $msg;
		}

		if ($latestVersion !== null) {
			$currentVersion = $this->settingManager->get("aodb_db_version");

			// if server version is greater than current version, download and load server version
			if ($currentVersion === false || $this->util->compareVersionNumbers($latestVersion, $currentVersion) > 0) {
				// download server version and save to ITEMS_MODULE directory
				$contents = $this->http
					->get("https://raw.githubusercontent.com/Budabot/Budabot/master/modules/ITEMS_MODULE/aodb{$latestVersion}.sql")
					->withHeader('User-Agent', 'Budabot')
					->waitAndReturnResponse()
					->body;

				$fh = fopen("./modules/ITEMS_MODULE/aodb{$latestVersion}.sql", 'w');
				fwrite($fh, $contents);
				fclose($fh);

				$this->db->beginTransaction();

				// load the sql file into the db
				$this->db->loadSQLFile("ITEMS_MODULE", "aodb");

				$this->db->commit();

				$this->logger->log('INFO', "Items db updated from '$currentVersion' to '$latestVersion'");
				$msg = "The items database has been updated to the latest version.  Version: $latestVersion";
			} else {
				$this->logger->log('DEBUG', "Items db already up to date '$currentVersion'");
				$msg = "The items database is already up to date.  Version: $currentVersion";
			}
		} else {
			$this->logger->log('ERROR', "Could not find latest items db on server");
			$msg = "There was a problem finding the latest version on the server";
		}

		$this->logger->log('DEBUG', "Finished items db update");

		return $msg;
	}

	public function findItems($args) {
		if (count($args) == 3) {
			$ql = $args[1];
			if (!($ql >= 1 && $ql <= 500)) {
				return "QL must be between 1 and 500.";
			}
			$search = $args[2];
		} else {
			$search = $args[1];
			$ql = false;
		}

		$search = htmlspecialchars_decode($search);
	
		// local database
		$data = $this->findItemsFromLocal($search, $ql);

		$budabotItemsExtractorLink = $this->text->makeChatcmd("Budabot Items Extractor", "/start https://github.com/Budabot/ItemsExtractor");
		$footer = "Item DB rips created using the $budabotItemsExtractorLink tool.";

		$msg = $this->createItemsBlob($data, $search, $ql, $this->settingManager->get('aodb_db_version'), 'local', $footer);

		return $msg;
	}
	
	public function findItemsFromLocal($search, $ql) {
		$tmp = explode(" ", $search);
		list($query, $params) = $this->util->generateQueryFromParams($tmp, 'name');

		if ($ql) {
			$query .= " AND `lowql` <= ? AND `highql` >= ?";
			$params []= $ql;
			$params []= $ql;
		}

		$sql = "SELECT * FROM aodb WHERE $query ORDER BY `name` ASC, highql DESC LIMIT 1000";
		$data = $this->db->query($sql, $params);
		$data = $this->orderSearchResults($data, $search);
		$data = array_slice($data, 0, $this->settingManager->get("maxitems"));
		
		return $data;
	}
	
	public function createItemsBlob($data, $search, $ql, $version, $server, $footer, $elapsed = null) {
		$num = count($data);
		if ($num == 0) {
			if ($ql) {
				$msg = "No QL <highlight>$ql<end> items found matching <highlight>$search<end>.";
			} else {
				$msg = "No items found matching <highlight>$search<end>.";
			}
			return $msg;
		} else if ($num < 4) {
			return trim($this->formatSearchResults($data, $ql, false));
		} else {
			$blob = "Version: <highlight>$version<end>\n";
			if ($ql) {
				$blob .= "Search: <highlight>QL $ql $search<end>\n";
			} else {
				$blob .= "Search: <highlight>$search<end>\n";
			}
			$blob .= "Server: <highlight>" . $server . "<end>\n";
			if ($elapsed) {
				$blob .= "Time: <highlight>" . round($elapsed, 2) . "s<end>\n";
			}
			$blob .= "\n";
			$blob .= $this->formatSearchResults($data, $ql, true);
			if ($num == $this->settingManager->get('maxitems')) {
				$blob .= "\n\n<highlight>*Results have been limited to the first " . $this->settingManager->get("maxitems") . " results.<end>";
			}
			$blob .= "\n\n" . $footer;
			$link = $this->text->makeBlob("Item Search Results ($num)", $blob);

			return $link;
		}
	}
	
	// sort by exact word matches higher than partial word matches
	public function orderSearchResults($data, $search) {
		$searchTerms = explode(" ", $search);
		forEach ($data as $row) {
			if (strcasecmp($search, $row->name) == 0) {
				$numExactMatches = 100;
			} else {
				$itemKeywords = preg_split("/\s/", $row->name);
				$numExactMatches = 0;
				forEach ($itemKeywords as $keyword) {
					forEach ($searchTerms as $searchWord) {
						if (strcasecmp($keyword, $searchWord) == 0) {
							$numExactMatches++;
							break;
						}
					}
				}
			}
			$row->numExactMatches = $numExactMatches;
		}
		
		$this->util->mergesort($data, function($a, $b) {
			if ($a->numExactMatches == $b->numExactMatches) {
				return 0;
			} else {
				return ($a->numExactMatches > $b->numExactMatches) ? -1 : 1;
			}
		});
		
		return $data;
	}

	public function formatSearchResults($data, $ql, $showImages) {
		$list = '';
		forEach ($data as $row) {
			if ($showImages) {
				$list .= $this->text->makeImage($row->icon) . "\n";
			}
			if ($ql) {
				$list .= "QL $ql " . $this->text->makeItem($row->lowid, $row->highid, $ql, $row->name);
			} else {
				$list .= $this->text->makeItem($row->lowid, $row->highid, $row->highql, $row->name);
			}
			if ($row->lowql != $row->highql) {
				$list .= " (QL" . $row->lowql . " - " . $row->highql . ")\n";
			} else {
				$list .= " (QL" . $row->lowql . ")\n";
			}
			if ($showImages) {
				$list .= "\n<pagebreak>";
			}
		}
		return $list;
	}
	
	private function escapeDescription($arr) {
		return "<description>" . htmlspecialchars($arr[1]) . "</description>";
	}
	
	public function findByName($name, $ql = null) {
		if ($ql === null) {
			return $this->db->queryRow("SELECT * FROM aodb WHERE name = ? ORDER BY highql DESC, highid DESC", $name);
		} else {
			return $this->db->queryRow("SELECT * FROM aodb WHERE name = ? AND lowql <= ? AND highql >= ? ORDER BY highid DESC", $name, $ql, $ql);
		}
	}

	public function getItem($name, $ql = null) {
		$row = $this->findByName($name, $ql);
		$ql = ($ql === null ? $row->highql : $ql);
		if ($row === null) {
			$this->logger->log("WARN", "Could not find item '$name' at QL '$ql'");
		} else {
			return $this->text->makeItem($row->lowid, $row->highid, $ql, $row->name);
		}
	}
	
	public function getItemAndIcon($name, $ql = null) {
		$row = $this->findByName($name, $ql);
		$ql = ($ql === null ? $row->highql : $ql);
		if ($row === null) {
			$this->logger->log("WARN", "Could not find item '$name' at QL '$ql'");
		} else {
			return $this->text->makeImage($row->icon) . "\n" .
				$this->text->makeItem($row->lowid, $row->highid, $ql, $row->name);
		}
	}
}
