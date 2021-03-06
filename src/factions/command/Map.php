<?php
/*
 *   FactionsPE: PocketMine-MP Plugin
 *   Copyright (C) 2016  Chris Prime
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace factions\command;

use dominate\Command;
use dominate\parameter\Parameter;

use localizer\Localizer;

use pocketmine\command\CommandSender;

use factions\utils\Collections;

class Map extends Command {
	
	public function setup() {
		# /faction map <auto-update>
		$this->addParameter(new Parameter("auto-update", Parameter::TYPE_BOOLEAN));
	}

	public function execute(CommandSender $sender, $label, array $args) {
		if(!parent::execute($sender, $label, $args)) return true;

		if (isset($args[0])) {
            $val = $args[0];
            $fsender = FPlayer::get($sender);
            if ($val) {
                $fsender->setMapAutoUpdating(true);
                $fsender->sendMessage(Localizer::translatable("map-auto-update-enabled"));
            } else {
                if($fsender->isMapAutoUpdating()) {
                    $fsender->setMapAutoUpdating(false);
                    $sender->sendMessage(Localizer::translatable("map-auto-update-disabled"));
                }
            }
            return true;
        }
          
        /** @var Player $sender $map */
        $map = Collections::getMap($sender, Collections::MAP_WIDTH, Collections::MAP_HEIGHT, $sender->getYaw());
        foreach ($map as $line) {
            $sender->sendMessage($line);
        }
        return true;
	}

}