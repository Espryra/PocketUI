<?php

declare(strict_types=1);

namespace PocketUI;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onEnable(): void
    {
        $this->getLogger()->info("PocketUI v" . $this->getDescription()->getVersion() . " has been enabled!");
        $this->getLogger()->info("Developers can now use PocketUI API to create custom GUIs!");
    }

    public function onDisable(): void
    {
        $this->getLogger()->info("PocketUI has been disabled!");
    }
}
