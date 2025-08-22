<?php

declare(strict_types=1);

namespace PocketUI\Utils;

class UIUtils {

    public const BLACK = "§0";
    public const DARK_BLUE = "§1";
    public const DARK_GREEN = "§2";
    public const DARK_AQUA = "§3";
    public const DARK_RED = "§4";
    public const DARK_PURPLE = "§5";
    public const GOLD = "§6";
    public const GRAY = "§7";
    public const DARK_GRAY = "§8";
    public const BLUE = "§9";
    public const GREEN = "§a";
    public const AQUA = "§b";
    public const RED = "§c";
    public const LIGHT_PURPLE = "§d";
    public const YELLOW = "§e";
    public const WHITE = "§f";

    public const OBFUSCATED = "§k";
    public const BOLD = "§l";
    public const STRIKETHROUGH = "§m";
    public const UNDERLINE = "§n";
    public const ITALIC = "§o";
    public const RESET = "§r";

    public static function colorize(string $text, string $color): string {
        return $color . $text . self::RESET;
    }

    public static function title(string $text): string {
        return self::BOLD . self::GOLD . $text . self::RESET;
    }

    public static function success(string $text): string {
        return self::GREEN . $text . self::RESET;
    }

    public static function error(string $text): string {
        return self::RED . $text . self::RESET;
    }

    public static function warning(string $text): string {
        return self::YELLOW . $text . self::RESET;
    }

    public static function info(string $text): string {
        return self::AQUA . $text . self::RESET;
    }

    public static function separator(int $length = 30, string $char = "-"): string {
        return self::GRAY . str_repeat($char, $length) . self::RESET;
    }

    public static function center(string $text, int $width = 50): string {
        $textLength = strlen(preg_replace('/§[0-9a-fk-or]/', '', $text));
        $padding = max(0, ($width - $textLength) / 2);
        return str_repeat(" ", (int) $padding) . $text;
    }

    public static function progressBar(float $percentage, int $width = 20, string $fillChar = "█", string $emptyChar = "░"): string {
        $percentage = max(0, min(100, $percentage));
        $filled = (int) (($percentage / 100) * $width);
        $empty = $width - $filled;
        
        return self::GREEN . str_repeat($fillChar, $filled) . 
               self::GRAY . str_repeat($emptyChar, $empty) . 
               self::WHITE . " " . number_format($percentage, 1) . "%" . self::RESET;
    }

    public static function clean(string $text): string {
        return preg_replace('/§[0-9a-fk-or]/', '', $text);
    }

    public static function getIcon(string $type): string {
        $icons = [
            "home" => "🏠",
            "settings" => "⚙",
            "user" => "👤",
            "shop" => "🛒",
            "money" => "💰",
            "star" => "⭐",
            "heart" => "❤",
            "check" => "✓",
            "cross" => "✗",
            "arrow_left" => "←",
            "arrow_right" => "→",
            "arrow_up" => "↑",
            "arrow_down" => "↓",
            "plus" => "+",
            "minus" => "-",
            "info" => "ℹ",
            "warning" => "⚠",
            "error" => "❌",
            "success" => "✅"
        ];
        
        return $icons[$type] ?? "";
    }

    public static function list(array $items, string $bullet = "•"): string {
        $result = "";
        foreach ($items as $item) {
            $result .= self::GRAY . $bullet . " " . self::WHITE . $item . "\n";
        }
        return rtrim($result, "\n");
    }

    public static function table(array $data, array $headers = []): string {
        $result = "";
        
        if (!empty($headers)) {
            $result .= self::BOLD . self::YELLOW . implode(" | ", $headers) . self::RESET . "\n";
            $result .= self::separator(strlen(implode(" | ", $headers))) . "\n";
        }
        
        foreach ($data as $row) {
            $result .= self::WHITE . implode(" | ", $row) . "\n";
        }
        
        return rtrim($result, "\n");
    }
}
