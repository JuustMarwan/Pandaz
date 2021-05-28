<?php

declare(strict_types=1);

namespace Zinkil\Pandaz\items;

use pocketmine\entity\Entity;
use pocketmine\item\ProjectileItem;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\Player;
use Zinkil\Pandaz\Core;
use Zinkil\Pandaz\CorePlayer;
use Zinkil\Pandaz\Utils;

class Splash extends ProjectileItem{
	
	public function __construct($meta=0){
		parent::__construct(Item::SPLASH_POTION, $meta, "Splash Potion");
	}
	public function getMaxStackSize():int{
		return 1;
	}
	public function onClickAir(Player $player, Vector3 $directionVector):bool{
		$motion=$player->getDirectionVector();
		$motion=$motion->multiply(0.2);
		$nbt=Entity::createBaseNBT($player->add(0, 0, 0), $motion);
		$hook=Entity::createEntity("CPPotion", $player->level, $nbt, $player);
		$hook->spawnToAll();
		$player->broadcastEntityEvent(AnimatePacket::ACTION_SWING_ARM);
	}
	public function getProjectileEntityType():string{
		return "CPPotion";
	}
	public function getThrowForce():float{
		return 0.5;
	}
}