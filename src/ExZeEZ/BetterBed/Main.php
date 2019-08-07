<?php

namespace PlayerTime;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\network\mcpe\protocol\SetTimePacket;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getLogger()->info(TextFormat::GREEN . "PlayerTime succesfully enabled!");
    }

    public function onDisable()
    {
        $this->getLogger()->info(TextFormat::RED . "PlayerTime disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "ptime":
                if (!$sender instanceof Player) {
                    $sender->sendMessage(TextFormat::RED . "This command is only in-game usable!");
                    return true;
                }
                if ($sender->hasPermission("exzeez.ptime")) {
                    if (isset($args[0])) {
                        if($args[0] == "set"){
                        if (isset($args[1])) {
                            if (is_numeric($args[1])) {
                                if ($args[1] > 0 && $args[1] < 12000) {
                                    $pk = new SetTimePacket();
                                    $pk->time = $args[1] & 0xffffffff;
                                    $sender->sendDataPacket($pk);
                                } else {
                                    $sender->sendMessage(TextFormat::RED . "You reach the limit please choose a number between 0 and 12000");
                                }
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Please specify a number!");
                            }
                        } else {
                            $sender->sendMessage(TextFormat::RED . "Use the command in this example! /ptime set 6000");
                            }
                        }
                    }
                }
                break;
        }
        return true;
    }
}
