<?php

declare(strict_types=1);

namespace JviguyGamesYT\IPPuller;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginManager;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{
    public $cfg;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info("IPPuller Is Now Enabled!");
        @mkdir($this->getDataFolder());
        $this->cfg = new Config($this->getDataFolder() . 'IPLIST.yml', Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "pullip":
                if ($sender->isOp()) {
                    if (empty($args)) {
                        $sender->sendMessage(TextFormat::GREEN . TextFormat::BOLD . TextFormat::ITALIC . "Usage: Pulls Ip Of A Player By There Name EX: /pullip shinystar1242");
                        return false;
                    }
                    foreach ($this->getServer()->getOnlinePlayers() as $onlinePlayer) {
                        $name = $args[0];
                        $playerbeingpulled = $this->getServer()->getPlayer($name);
                        if ($playerbeingpulled === null) {
                            $sender->sendMessage(TextFormat::BOLD . TextFormat::ITALIC . TextFormat::RED . "That Player Is not Online!");
                            return false;
                        } else {
                            $playersip = $playerbeingpulled->getAddress();
                            $sender->sendMessage(TextFormat::AQUA . TextFormat::ITALIC . TextFormat::BOLD . "Player {$name}'s IP is {$playersip}");
                            return false;
                        }
                    }

                } else {
                    $sender->sendMessage(TextFormat::RED . TextFormat::ITALIC . TextFormat::BOLD . "You Dont Have The Required Permission To Use This Command!");
                }
                break;
            case "pullallips":
                if ($sender->isOp()) {
                    foreach ($this->getServer()->getOnlinePlayers() as $onlinePlayers) {
                        $ips = $onlinePlayers->getAddress();
                        $sender->sendMessage(TextFormat::AQUA . TextFormat::BOLD . TextFormat::ITALIC . "IPS:{$ips}");
                        return false;
                    }
                }
        }
        return true;
    }
}