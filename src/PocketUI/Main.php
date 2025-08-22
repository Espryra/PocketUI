<?php

declare(strict_types=1);

namespace PocketUI;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use PocketUI\UI\UIManager;
use PocketUI\UI\Forms\SimpleForm;
use PocketUI\UI\Forms\ModalForm;
use PocketUI\UI\Forms\CustomForm;

class Main extends PluginBase implements Listener {

    private UIManager $uiManager;

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->uiManager = new UIManager($this);
        
        $this->getLogger()->info("PocketUI v" . $this->getDescription()->getVersion() . " has been enabled!");
        $this->getLogger()->info("Developers can now use PocketUI API to create custom GUIs!");
    }

    public function onDisable(): void {
        $this->getLogger()->info("PocketUI has been disabled!");
    }

    public function getUIManager(): UIManager {
        return $this->uiManager;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "pocketui") {
            if (!$sender instanceof Player) {
                $sender->sendMessage("§cThis command can only be used in-game!");
                return true;
            }

            if (!$sender->hasPermission("pocketui.admin")) {
                $sender->sendMessage("§cYou don't have permission to use this command!");
                return true;
            }

            $this->showDemoUI($sender);
            return true;
        }
        return false;
    }

    private function showDemoUI(Player $player): void {
        $form = new SimpleForm("PocketUI Demo", "Welcome to PocketUI! This is a demo showing different UI types.");
        
        $form->addButton("Simple Form Demo", "https://cdn-icons-png.flaticon.com/512/1828/1828884.png", function(Player $player) {
            $this->showSimpleFormDemo($player);
        });
        
        $form->addButton("Modal Form Demo", "https://cdn-icons-png.flaticon.com/512/1828/1828886.png", function(Player $player) {
            $this->showModalFormDemo($player);
        });
        
        $form->addButton("Custom Form Demo", "https://cdn-icons-png.flaticon.com/512/1828/1828888.png", function(Player $player) {
            $this->showCustomFormDemo($player);
        });
        
        $form->addButton("§cClose", null, function(Player $player) {
            $player->sendMessage("§aDemo closed!");
        });
        
        $this->uiManager->sendForm($player, $form);
    }

    private function showSimpleFormDemo(Player $player): void {
        $form = new SimpleForm("Simple Form Demo", "This is a simple form with buttons. Click any option:");
        
        $form->addButton("§aOption 1", null, function(Player $player) {
            $player->sendMessage("§aYou clicked Option 1!");
        });
        
        $form->addButton("§bOption 2", null, function(Player $player) {
            $player->sendMessage("§bYou clicked Option 2!");
        });
        
        $form->addButton("§eOption 3", null, function(Player $player) {
            $player->sendMessage("§eYou clicked Option 3!");
        });
        
        $form->addButton("§cBack", null, function(Player $player) {
            $this->showDemoUI($player);
        });
        
        $this->uiManager->sendForm($player, $form);
    }

    private function showModalFormDemo(Player $player): void {
        $form = new ModalForm("Modal Form Demo", "Do you want to proceed with this action?", "§aYes", "§cNo");
        
        $form->setSubmitCallback(function(Player $player, bool $choice) {
            if ($choice) {
                $player->sendMessage("§aYou chose Yes!");
            } else {
                $player->sendMessage("§cYou chose No!");
            }
            $this->showDemoUI($player);
        });
        
        $this->uiManager->sendForm($player, $form);
    }

    private function showCustomFormDemo(Player $player): void {
        $form = new CustomForm("Custom Form Demo");
        
        $form->addLabel("Fill out this form:");
        $form->addInput("Enter your name:", "Your name here...");
        $form->addSlider("Select your level:", 1, 100, 1, 50);
        $form->addStepSlider("Choose your rank:", ["Beginner", "Intermediate", "Advanced", "Expert"]);
        $form->addDropdown("Select your favorite game mode:", ["Survival", "Creative", "Adventure", "Spectator"]);
        $form->addToggle("Enable notifications:", true);
        
        $form->setSubmitCallback(function(Player $player, array $data) {
            $name = $data[1] ?? "Unknown";
            $level = $data[2] ?? 50;
            $rank = ["Beginner", "Intermediate", "Advanced", "Expert"][$data[3]] ?? "Beginner";
            $gamemode = ["Survival", "Creative", "Adventure", "Spectator"][$data[4]] ?? "Survival";
            $notifications = $data[5] ?? true;
            
            $player->sendMessage("§aForm submitted!");
            $player->sendMessage("§7Name: §f" . $name);
            $player->sendMessage("§7Level: §f" . $level);
            $player->sendMessage("§7Rank: §f" . $rank);
            $player->sendMessage("§7Game Mode: §f" . $gamemode);
            $player->sendMessage("§7Notifications: §f" . ($notifications ? "Enabled" : "Disabled"));
            
            $this->showDemoUI($player);
        });
        
        $this->uiManager->sendForm($player, $form);
    }
}
