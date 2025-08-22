<?php

declare(strict_types=1);

namespace PocketUI\UI\Forms;

use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class BaseForm implements Form {

    protected string $title;
    protected $submitCallback = null;
    protected $closeCallback = null;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function setSubmitCallback(callable $callback): self {
        $this->submitCallback = $callback;
        return $this;
    }

    public function setCloseCallback(callable $callback): self {
        $this->closeCallback = $callback;
        return $this;
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null) {
            if ($this->closeCallback !== null) {
                ($this->closeCallback)($player);
            }
        } else {
            if ($this->submitCallback !== null) {
                ($this->submitCallback)($player, $data);
            }
        }
    }

    abstract public function getType(): string;

    abstract public function jsonSerialize(): array;
}
