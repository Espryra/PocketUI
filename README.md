# PocketUI - PocketMine-MP UI API

A comprehensive and easy-to-use UI API library for PocketMine-MP that allows developers to create beautiful and interactive user interfaces with minimal code.

## Features

- Simple Forms - Button-based menus with images and callbacks
- Modal Forms - Yes/No confirmation dialogs
- Custom Forms - Complex forms with inputs, sliders, dropdowns, toggles, etc.
- Fluent API - Chain methods for easy form building
- UI Utils - Color formatting, icons, and styling utilities
- Built-in Examples - Demo forms to show usage

## Installation

1. Download the PocketUI plugin
2. Place it in your plugins folder
3. Restart your server
4. Other plugins can now use PocketUI as a dependency

## Quick Start

### Basic Usage

```php
use PocketUI\UI\Forms\SimpleForm;
use PocketUI\UI\Forms\ModalForm;
use PocketUI\UI\Forms\CustomForm;

$pocketUI = $this->getServer()->getPluginManager()->getPlugin("PocketUI");
$uiManager = $pocketUI->getUIManager();

$form = new SimpleForm("My Menu", "Choose an option:");
$form->addButton("Option 1", null, function($player) {
    $player->sendMessage("You clicked Option 1!");
});
$form->addButton("Option 2", null, function($player) {
    $player->sendMessage("You clicked Option 2!");
});

$uiManager->sendForm($player, $form);
```

### Using the UI Builder (Recommended)

```php
use PocketUI\UI\Builder\UIBuilder;

$form = UIBuilder::simpleForm("Shop", "What would you like to buy?")
    ->addButton("§aSword", "https://example.com/sword.png", function($player) {
        // Handle sword purchase
    })
    ->addButton("§bArmor", "https://example.com/armor.png", function($player) {
        // Handle armor purchase
    })
    ->addButton("§cClose", null, function($player) {
        $player->sendMessage("Shop closed!");
    });

$uiManager->sendForm($player, $form);
```

## Form Types

### 1. Simple Form (Menu with Buttons)

```php
$form = new SimpleForm("Title", "Description");

$form->addButton("Button Text", "image_url", function($player) {
    // Button clicked
});

$form->addButtonWithPathImage("Button", "textures/items/diamond_sword", function($player) {
    // Button clicked
});
```

### 2. Modal Form (Yes/No Dialog)

```php
$form = new ModalForm("Confirm", "Are you sure?", "Yes", "No");
$form->setSubmitCallback(function($player, $choice) {
    if ($choice) {
        // User clicked "Yes"
    } else {
        // User clicked "No"
    }
});
```

### 3. Custom Form (Advanced Input Form)

```php
$form = new CustomForm("Settings");

$form->addLabel("Configure your settings:");
$form->addInput("Enter name:", "Your name...", "DefaultName");
$form->addToggle("Enable notifications:", true);
$form->addSlider("Volume:", 0, 100, 1, 50);
$form->addDropdown("Language:", ["English", "Spanish", "French"], 0);
$form->addStepSlider("Difficulty:", ["Easy", "Normal", "Hard"], 1);

$form->setSubmitCallback(function($player, $data) {
    $name = $data[1];
    $notifications = $data[2];
    $volume = $data[3];
    $language = $data[4];
    $difficulty = $data[5];
    
    // Process form data
});
```

## UI Builder Methods

```php
$form = UIBuilder::confirmDialog(
    "Delete Item", 
    "Are you sure you want to delete this item?",
    function($player) {
        // Confirmed
    },
    function($player) {
        // Cancelled
    }
);

$form = UIBuilder::infoDialog(
    "Information",
    "This is some important information!",
    function($player) {
        // Dialog closed
    }
);

$menu = UIBuilder::menu("Main Menu", "Choose an option:")
    ->addButton("Play", null, $playCallback)
    ->addButton("Settings", null, $settingsCallback)
    ->addButton("Quit", null, $quitCallback);
```

## UI Utils for Styling

```php
use PocketUI\Utils\UIUtils;

$text = UIUtils::colorize("Hello World", UIUtils::GREEN);
$title = UIUtils::title("Important Title");
$success = UIUtils::success("Operation successful!");
$error = UIUtils::error("Something went wrong!");

$progress = UIUtils::progressBar(75);

$homeIcon = UIUtils::getIcon("home");
$settingsIcon = UIUtils::getIcon("settings");

$list = UIUtils::list(["Item 1", "Item 2", "Item 3"]);
$table = UIUtils::table([
    ["Name", "Level", "Score"],
    ["Player1", "50", "1000"],
    ["Player2", "45", "950"]
]);
```

## Example Plugin Using PocketUI

```php
<?php

namespace MyPlugin;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use PocketUI\UI\Builder\UIBuilder;
use PocketUI\Utils\UIUtils;

class MyPlugin extends PluginBase {

    private $pocketUI;

    public function onEnable(): void {
        $this->pocketUI = $this->getServer()->getPluginManager()->getPlugin("PocketUI");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "shop" && $sender instanceof Player) {
            $this->openShop($sender);
            return true;
        }
        return false;
    }

    private function openShop(Player $player): void {
        $form = UIBuilder::simpleForm(
            UIUtils::title("🛒 Server Shop"),
            "Welcome to the shop! What would you like to buy?"
        );

        $form->addButton(
            UIUtils::success("⚔️ Weapons"),
            null,
            function(Player $player) {
                $this->openWeaponsShop($player);
            }
        );

        $form->addButton(
            UIUtils::info("🛡️ Armor"), 
            null,
            function(Player $player) {
                $this->openArmorShop($player);
            }
        );

        $form->addButton(
            UIUtils::error("❌ Close"),
            null,
            function(Player $player) {
                $player->sendMessage(UIUtils::success("Thanks for visiting!"));
            }
        );

        $this->pocketUI->getUIManager()->sendForm($player, $form);
    }
}
```

## Commands

- `/pocketui` - Opens the PocketUI demo interface (requires `pocketui.admin` permission)

## API Reference

### UIManager
- `sendForm(Player $player, BaseForm $form): void` - Send a form to a player
- `getPlugin(): Plugin` - Get the PocketUI plugin instance

### Form Classes
- `SimpleForm` - Button-based menus
- `ModalForm` - Yes/No dialogs  
- `CustomForm` - Complex input forms

### UIBuilder
- `simpleForm(title, content)` - Create simple form
- `modalForm(title, content, btn1, btn2)` - Create modal form
- `customForm(title)` - Create custom form
- `confirmDialog(title, message, onConfirm, onCancel)` - Create confirmation
- `infoDialog(title, message, onClose)` - Create info dialog

### UIUtils
- Color constants and formatting methods
- `colorize(text, color)` - Apply color to text
- `title/success/error/warning/info(text)` - Quick formatting
- `progressBar(percentage)` - Create progress bars
- `getIcon(type)` - Get common icons

## License

This project is open source. Feel free to modify and distribute according to your needs.