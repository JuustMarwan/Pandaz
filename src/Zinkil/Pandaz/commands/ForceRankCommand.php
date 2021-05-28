<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\Commands;

use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use Zinkil\Pandaz\Core;

class ForceRankCommand extends PluginCommand{
	
	private $plugin;
	
	public function __construct(Core $plugin){
		parent::__construct("forcerank", $plugin);
		$this->plugin=$plugin;
		$this->setDescription("§bGive a player a forced rank");
		$this->setPermission("Pandaz.command.forcerank");
	}
	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player->hasPermission("Pandaz.command.forcerank")){
			$player->sendMessage("§cYou cannot execute this command.");
			return;
		}
		if(!isset($args[0])){
			return;
		}
		if(!isset($args[1])){
			return;
		}
		$this->plugin->getDatabaseHandler()->setRank($args[0], $args[1]);
		$this->plugin->getLogger()->notice($args[0]." was forced the ".$args[1]." rank.");
	}
}