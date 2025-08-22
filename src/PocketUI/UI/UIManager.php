<?php

declare(strict_types=1);

namespace PocketUI\UI;

use pocketmine\plugin\Plugin;
use pocketmine\player\Player;
use pocketmine\form\Form;
use PocketUI\UI\Forms\BaseForm;

class UIManager {

    private Plugin $plugin;
    private array $activeForms = [];

    public function __construct(Plugin $plugin) {
        $this->plugin = $plugin;
    }

    public function sendForm(Player $player, BaseForm $form): void {
        $formId = $player->sendForm($form);
        if ($formId !== null) {
            $this->activeForms[$player->getName()][$formId] = $form;
        }
    }

    public function getPlugin(): Plugin {
        return $this->plugin;
    }

    public function removeForm(Player $player, int $formId): void {
        unset($this->activeForms[$player->getName()][$formId]);
        if (empty($this->activeForms[$player->getName()])) {
            unset($this->activeForms[$player->getName()]);
        }
    }

    public function getForm(Player $player, int $formId): ?BaseForm {
        return $this->activeForms[$player->getName()][$formId] ?? null;
    }

    public function clearForms(Player $player): void {
        unset($this->activeForms[$player->getName()]);
    }

    public function getPlayerForms(Player $player): array {
        return $this->activeForms[$player->getName()] ?? [];
    }
}
