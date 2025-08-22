<?php

declare(strict_types=1);

namespace PocketUI\UI\Forms;

use pocketmine\player\Player;

class SimpleForm extends BaseForm {

    private string $content;
    private array $buttons = [];

    public function __construct(string $title, string $content = "") {
        parent::__construct($title);
        $this->content = $content;
    }

    public function setContent(string $content): self {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function addButton(string $text, ?string $imageUrl = null, ?callable $onClick = null): self {
        $button = ["text" => $text];
        
        if ($imageUrl !== null) {
            $button["image"] = [
                "type" => "url",
                "data" => $imageUrl
            ];
        }

        $this->buttons[] = [
            "data" => $button,
            "callback" => $onClick
        ];
        
        return $this;
    }

    public function addButtonWithPathImage(string $text, string $imagePath, ?callable $onClick = null): self {
        $button = [
            "text" => $text,
            "image" => [
                "type" => "path",
                "data" => $imagePath
            ]
        ];

        $this->buttons[] = [
            "data" => $button,
            "callback" => $onClick
        ];
        
        return $this;
    }

    public function clearButtons(): self {
        $this->buttons = [];
        return $this;
    }

    public function getButtonCount(): int {
        return count($this->buttons);
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null) {
            if ($this->closeCallback !== null) {
                ($this->closeCallback)($player);
            }
            return;
        }

        if (!is_int($data) || !isset($this->buttons[$data])) {
            return;
        }

        $button = $this->buttons[$data];
        if ($button["callback"] !== null) {
            ($button["callback"])($player);
        }

        if ($this->submitCallback !== null) {
            ($this->submitCallback)($player, $data);
        }
    }

    public function getType(): string {
        return "form";
    }

    public function jsonSerialize(): array {
        $buttons = [];
        foreach ($this->buttons as $button) {
            $buttons[] = $button["data"];
        }

        return [
            "type" => "form",
            "title" => $this->title,
            "content" => $this->content,
            "buttons" => $buttons
        ];
    }
}
