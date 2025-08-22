<?php

declare(strict_types=1);

namespace PocketUI\UI\Forms;

use pocketmine\player\Player;

class ModalForm extends BaseForm {

    private string $content;
    private string $button1;
    private string $button2;

    public function __construct(string $title, string $content, string $button1 = "Yes", string $button2 = "No") {
        parent::__construct($title);
        $this->content = $content;
        $this->button1 = $button1;
        $this->button2 = $button2;
    }

    public function setContent(string $content): self {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setButton1(string $text): self {
        $this->button1 = $text;
        return $this;
    }

    public function setButton2(string $text): self {
        $this->button2 = $text;
        return $this;
    }

    public function getButton1(): string {
        return $this->button1;
    }

    public function getButton2(): string {
        return $this->button2;
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null) {
            if ($this->closeCallback !== null) {
                ($this->closeCallback)($player);
            }
            return;
        }

        if ($this->submitCallback !== null) {
            ($this->submitCallback)($player, (bool) $data);
        }
    }

    public function getType(): string {
        return "modal";
    }

    public function jsonSerialize(): array {
        return [
            "type" => "modal",
            "title" => $this->title,
            "content" => $this->content,
            "button1" => $this->button1,
            "button2" => $this->button2
        ];
    }
}
