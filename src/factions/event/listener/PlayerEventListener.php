<?php
/**
 * Created by PhpStorm.
 * User: primus
 * Date: 5/20/16
 * Time: 2:43 PM
 */

namespace factions\event\listener;

use factions\base\ListenerBase;
use factions\faction\Factions;
use factions\objs\FPlayer;
use factions\objs\Rel;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerEventListener extends ListenerBase
{

    public function onPlayerJoin(PlayerJoinEvent $e){
    }


    /**
     * @param PlayerChatEvent $e
     * @priority HIGHEST
     * @ignoreCancelled false
     */
    public function onPlayerChat(PlayerChatEvent $e){
        $fplayer = FPlayer::get($e->getPlayer());
        if($fplayer->hasFaction()){

            $faction = $fplayer->getFaction();
            $r = $fplayer->getRank();
            if($r === Rel::LEADER)
                $rank = "***";
            elseif ($r === Rel::OFFICER)
                $rank = "**";
            else
                $rank = "*";

            $e->setFormat("[$rank{$faction->getName()}] {$fplayer->getName()}: ".$e->getMessage());
        }
    }
}