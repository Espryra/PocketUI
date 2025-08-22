<?php

declare(strict_types=1);

namespace PocketUI\UI\Elements;

class Button {

    private string $text;
    private ?string $imageType = null;
    private ?string $imageData = null;
    private $onClick = null;

    public function __construct(string $text) {
        $this->text = $text;
    }

    public function setText(string $text): self {
        $this->text = $text;
        return $this;
    }

    public function setImageUrl(string $url): self {
        $this->imageType = "url";
        $this->imageData = $url;
        return $this;
    }

    public function setImagePath(string $path): self {
        $this->imageType = "path";
        $this->imageData = $path;
        return $this;
    }

    public function setOnClick(callable $callback): self {
        $this->onClick = $callback;
        return $this;
    }

    public function getText(): string {
        return $this->text;
    }

    public function getOnClick(): ?callable {
        return $this->onClick;
    }

    public function toArray(): array {
        $data = ["text" => $this->text];
        
        if ($this->imageType !== null && $this->imageData !== null) {
            $data["image"] = [
                "type" => $this->imageType,
                "data" => $this->imageData
            ];
        }
        
        return $data;
    }
}
