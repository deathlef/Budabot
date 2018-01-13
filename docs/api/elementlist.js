
var ApiGen = ApiGen || {};
ApiGen.elements = [["c","AccessLevel"],["c","Budabot\\Core\\AccessManager"],["c","Budabot\\Core\\AdminManager"],["c","Budabot\\Core\\AOChat"],["c","Budabot\\Core\\AOChatPacket"],["c","Budabot\\Core\\AOChatQueue"],["c","Budabot\\Core\\AOExtMsg"],["c","Budabot\\Core\\AsyncHttp"],["c","Budabot\\Core\\AutoInject"],["c","Budabot\\Core\\BanManager"],["c","Budabot\\Core\\BotRunner"],["c","Budabot\\Core\\Budabot"],["c","Budabot\\Core\\BuddylistManager"],["c","Budabot\\Core\\CacheManager"],["c","Budabot\\Core\\CacheResult"],["c","Budabot\\Core\\ClassLoader"],["c","Budabot\\Core\\ColorSettingHandler"],["c","Budabot\\Core\\CommandAlias"],["c","Budabot\\Core\\CommandManager"],["c","Budabot\\Core\\CommandReply"],["c","Budabot\\Core\\ConfigFile"],["c","Budabot\\Core\\DB"],["c","Budabot\\Core\\DBRow"],["c","Budabot\\Core\\EventLoop"],["c","Budabot\\Core\\EventManager"],["c","Budabot\\Core\\GuildChannelCommandReply"],["c","Budabot\\Core\\GuildManager"],["c","Budabot\\Core\\HelpManager"],["c","Budabot\\Core\\Http"],["c","Budabot\\Core\\HttpRequest"],["c","Budabot\\Core\\InvalidHttpRequest"],["c","Budabot\\Core\\LegacyLogger"],["c","Budabot\\Core\\LimitsController"],["c","Budabot\\Core\\LoggerWrapper"],["c","Budabot\\Core\\MMDBParser"],["c","Budabot\\Core\\Modules\\AdminController"],["c","Budabot\\Core\\Modules\\AliasController"],["c","Budabot\\Core\\Modules\\AltInfo"],["c","Budabot\\Core\\Modules\\AltsController"],["c","Budabot\\Core\\Modules\\BanController"],["c","Budabot\\Core\\Modules\\BuddylistController"],["c","Budabot\\Core\\Modules\\ColorsController"],["c","Budabot\\Core\\Modules\\CommandlistController"],["c","Budabot\\Core\\Modules\\CommandSearchController"],["c","Budabot\\Core\\Modules\\ConfigController"],["c","Budabot\\Core\\Modules\\EventlistController"],["c","Budabot\\Core\\Modules\\HelpController"],["c","Budabot\\Core\\Modules\\LogsController"],["c","Budabot\\Core\\Modules\\PlayerLookupController"],["c","Budabot\\Core\\Modules\\ProfileCommandReply"],["c","Budabot\\Core\\Modules\\ProfileController"],["c","Budabot\\Core\\Modules\\SettingsController"],["c","Budabot\\Core\\Modules\\SQLController"],["c","Budabot\\Core\\Modules\\SystemController"],["c","Budabot\\Core\\Modules\\UsageController"],["c","Budabot\\Core\\Modules\\WhitelistController"],["c","Budabot\\Core\\NumberSettingHandler"],["c","Budabot\\Core\\OptionsSettingHandler"],["c","Budabot\\Core\\PlayerHistory"],["c","Budabot\\Core\\PlayerHistoryManager"],["c","Budabot\\Core\\PlayerManager"],["c","Budabot\\Core\\Preferences"],["c","Budabot\\Core\\PrivateChannelCommandReply"],["c","Budabot\\Core\\PrivateMessageCommandReply"],["c","Budabot\\Core\\Registry"],["c","Budabot\\Core\\SettingHandler"],["c","Budabot\\Core\\SettingManager"],["c","Budabot\\Core\\SettingObject"],["c","Budabot\\Core\\SocketManager"],["c","Budabot\\Core\\SocketNotifier"],["c","Budabot\\Core\\SQLException"],["c","Budabot\\Core\\StopExecutionException"],["c","Budabot\\Core\\SubcommandManager"],["c","Budabot\\Core\\Text"],["c","Budabot\\Core\\TextSettingHandler"],["c","Budabot\\Core\\Timer"],["c","Budabot\\Core\\TimerEvent"],["c","Budabot\\Core\\TimeSettingHandler"],["c","Budabot\\Core\\Util"],["c","Budabot\\Core\\xml"],["c","Budabot\\User\\Modules\\AlienArmorController"],["c","Budabot\\User\\Modules\\AlienBioController"],["c","Budabot\\User\\Modules\\AlienMiscController"],["c","Budabot\\User\\Modules\\AOSpeakController"],["c","Budabot\\User\\Modules\\AOUController"],["c","Budabot\\User\\Modules\\AutoJoinController"],["c","Budabot\\User\\Modules\\AXPController"],["c","Budabot\\User\\Modules\\BankController"],["c","Budabot\\User\\Modules\\BosslootController"],["c","Budabot\\User\\Modules\\BroadcastController"],["c","Budabot\\User\\Modules\\BuffPerksController"],["c","Budabot\\User\\Modules\\CacheController"],["c","Budabot\\User\\Modules\\ChatAssistController"],["c","Budabot\\User\\Modules\\ChatCheckController"],["c","Budabot\\User\\Modules\\ChatLeaderController"],["c","Budabot\\User\\Modules\\ChatRallyController"],["c","Budabot\\User\\Modules\\ChatSayController"],["c","Budabot\\User\\Modules\\ChatTopicController"],["c","Budabot\\User\\Modules\\CityWaveController"],["c","Budabot\\User\\Modules\\CloakController"],["c","Budabot\\User\\Modules\\ClusterController"],["c","Budabot\\User\\Modules\\CountdownController"],["c","Budabot\\User\\Modules\\DevController"],["c","Budabot\\User\\Modules\\DingController"],["c","Budabot\\User\\Modules\\EventsController"],["c","Budabot\\User\\Modules\\ExternalCommandController"],["c","Budabot\\User\\Modules\\ExternalPrivateChannelController"],["c","Budabot\\User\\Modules\\FightController"],["c","Budabot\\User\\Modules\\FindOrgController"],["c","Budabot\\User\\Modules\\FindPlayerController"],["c","Budabot\\User\\Modules\\FunController"],["c","Budabot\\User\\Modules\\GitController"],["c","Budabot\\User\\Modules\\GuideController"],["c","Budabot\\User\\Modules\\GuildChannelCommandReplyA"],["c","Budabot\\User\\Modules\\GuildController"],["c","Budabot\\User\\Modules\\HelpbotController"],["c","Budabot\\User\\Modules\\HtmlDecodeController"],["c","Budabot\\User\\Modules\\ImplantController"],["c","Budabot\\User\\Modules\\ImplantDesignerController"],["c","Budabot\\User\\Modules\\InactiveMemberController"],["c","Budabot\\User\\Modules\\IRCCommandReply"],["c","Budabot\\User\\Modules\\IRCController"],["c","Budabot\\User\\Modules\\ItemsController"],["c","Budabot\\User\\Modules\\KillOnSightController"],["c","Budabot\\User\\Modules\\LevelController"],["c","Budabot\\User\\Modules\\LinksController"],["c","Budabot\\User\\Modules\\LootListsController"],["c","Budabot\\User\\Modules\\MdbController"],["c","Budabot\\User\\Modules\\MockCommandReply"],["c","Budabot\\User\\Modules\\NanoController"],["c","Budabot\\User\\Modules\\NewsController"],["c","Budabot\\User\\Modules\\NoSymbolController"],["c","Budabot\\User\\Modules\\NotesController"],["c","Budabot\\User\\Modules\\OnlineController"],["c","Budabot\\User\\Modules\\OrgHistoryController"],["c","Budabot\\User\\Modules\\OrglistController"],["c","Budabot\\User\\Modules\\OrgMembersController"],["c","Budabot\\User\\Modules\\OSController"],["c","Budabot\\User\\Modules\\PlayerHistoryController"],["c","Budabot\\User\\Modules\\PlayfieldController"],["c","Budabot\\User\\Modules\\PocketbossController"],["c","Budabot\\User\\Modules\\PremadeImplantController"],["c","Budabot\\User\\Modules\\PrivateChannelCommandReplyA"],["c","Budabot\\User\\Modules\\PrivateChannelController"],["c","Budabot\\User\\Modules\\QuoteController"],["c","Budabot\\User\\Modules\\RaffleController"],["c","Budabot\\User\\Modules\\RaidController"],["c","Budabot\\User\\Modules\\RandomController"],["c","Budabot\\User\\Modules\\RecipeController"],["c","Budabot\\User\\Modules\\RelayController"],["c","Budabot\\User\\Modules\\RenameTablesController"],["c","Budabot\\User\\Modules\\ReplySizeCommandReply"],["c","Budabot\\User\\Modules\\ReputationController"],["c","Budabot\\User\\Modules\\ResearchController"],["c","Budabot\\User\\Modules\\RunAsController"],["c","Budabot\\User\\Modules\\SendTellController"],["c","Budabot\\User\\Modules\\ShoppingController"],["c","Budabot\\User\\Modules\\SilenceController"],["c","Budabot\\User\\Modules\\SkillsController"],["c","Budabot\\User\\Modules\\SpiritsController"],["c","Budabot\\User\\Modules\\StopwatchController"],["c","Budabot\\User\\Modules\\Teamspeak3"],["c","Budabot\\User\\Modules\\TeamspeakController"],["c","Budabot\\User\\Modules\\TestController"],["c","Budabot\\User\\Modules\\TimeController"],["c","Budabot\\User\\Modules\\TimerController"],["c","Budabot\\User\\Modules\\TimezoneController"],["c","Budabot\\User\\Modules\\TowerController"],["c","Budabot\\User\\Modules\\TrackerController"],["c","Budabot\\User\\Modules\\TrickleController"],["c","Budabot\\User\\Modules\\UnixtimeController"],["c","Budabot\\User\\Modules\\VoteController"],["c","Budabot\\User\\Modules\\WeatherController"],["c","Budabot\\User\\Modules\\WhatBuffs1Controller"],["c","Budabot\\User\\Modules\\WhatBuffs2Controller"],["c","Budabot\\User\\Modules\\WhereisController"],["c","Budabot\\User\\Modules\\WhoisController"],["c","Budabot\\User\\Modules\\WhoisOrgController"],["c","Budabot\\User\\Modules\\WhompahController"],["c","Command"],["c","DefaultStatus"],["c","DefineCommand"],["c","Description"],["c","Event"],["c","HandlesCommand"],["c","Help"],["c","Inject"],["c","Instance"],["c","Intoptions"],["f","isWindows()"],["c","Matches"],["c","Options"],["f","read_input()"],["c","Setting"],["c","Setup"],["c","Type"],["c","Visibility"]];