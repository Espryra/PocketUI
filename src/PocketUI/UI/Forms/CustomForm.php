<?php

declare(strict_types=1);

namespace PocketUI\UI\Forms;

use pocketmine\player\Player;

class CustomForm extends BaseForm {

    private array $elements = [];

    public function __construct(string $title) {
        parent::__construct($title);
    }

    public function addLabel(string $text): self {
        $this->elements[] = [
            "type" => "label",
            "text" => $text
        ];
        return $this;
    }

    public function addInput(string $text, string $placeholder = "", string $default = ""): self {
        $this->elements[] = [
            "type" => "input",
            "text" => $text,
            "placeholder" => $placeholder,
            "default" => $default
        ];
        return $this;
    }

    public function addToggle(string $text, bool $default = false): self {
        $this->elements[] = [
            "type" => "toggle",
            "text" => $text,
            "default" => $default
        ];
        return $this;
    }

    public function addSlider(string $text, float $min = 0, float $max = 100, float $step = 1, float $default = 0): self {
        $this->elements[] = [
            "type" => "slider",
            "text" => $text,
            "min" => $min,
            "max" => $max,
            "step" => $step,
            "default" => $default
        ];
        return $this;
    }

    public function addStepSlider(string $text, array $steps, int $default = 0): self {
        $this->elements[] = [
            "type" => "step_slider",
            "text" => $text,
            "steps" => $steps,
            "default" => $default
        ];
        return $this;
    }

    public function addDropdown(string $text, array $options, int $default = 0): self {
        $this->elements[] = [
            "type" => "dropdown",
            "text" => $text,
            "options" => $options,
            "default" => $default
        ];
        return $this;
    }

    public function getElementCount(): int {
        return count($this->elements);
    }

    public function clearElements(): self {
        $this->elements = [];
        return $this;
    }

    public function getElements(): array {
        return $this->elements;
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null) {
            if ($this->closeCallback !== null) {
                ($this->closeCallback)($player);
            }
            return;
        }

        if (!is_array($data)) {
            return;
        }

        if ($this->submitCallback !== null) {
            ($this->submitCallback)($player, $data);
        }
    }

    public function getType(): string {
        return "custom_form";
    }

    public function jsonSerialize(): array {
        return [
            "type" => "custom_form",
            "title" => $this->title,
            "content" => $this->elements
        ];
    }
}
