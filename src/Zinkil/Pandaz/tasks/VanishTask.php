<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\tasks;

use pocketmine\scheduler\Task;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;
use Zinkil\Pandaz\Core;

class VanishTask extends Task{
	
	public function __construct(Core $plugin){
		$this->plugin=$plugin;
	}
	public function onRun(int $tick):void{
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
			if($player->spawned){
				if($player->isVanished()){
					$player->sendPopup("You are currently in §bVANISH");
					foreach($this->plugin->getServer()->getOnlinePlayers() as $online){
						if($online->hasPermission("Pandaz.bypass.vanishsee")){
							$online->showPlayer($player);
						}else{
							$online->hidePlayer($player);
							$entry=new PlayerListEntry();
							$entry->uuid=$player->getUniqueId();
							$packet=new PlayerListPacket();
							$packet->entries[]=$entry;
							$packet->type=PlayerListPacket::TYPE_REMOVE;
							$online->sendDataPacket($packet);
						}
					}
				}
			}
		}
	}
}