<?php

declare(strict_types=1);

namespace PocketUI\UI\Builder;

use PocketUI\UI\Forms\SimpleForm;
use PocketUI\UI\Forms\ModalForm;
use PocketUI\UI\Forms\CustomForm;
use PocketUI\UI\Elements\Button;

class UIBuilder {

    public static function simpleForm(string $title, string $content = ""): SimpleForm {
        return new SimpleForm($title, $content);
    }

    public static function modalForm(string $title, string $content, string $button1 = "Yes", string $button2 = "No"): ModalForm {
        return new ModalForm($title, $content, $button1, $button2);
    }

    public static function customForm(string $title): CustomForm {
        return new CustomForm($title);
    }

    public static function button(string $text): Button {
        return new Button($text);
    }

    public static function confirmDialog(string $title, string $message, callable $onConfirm, ?callable $onCancel = null): ModalForm {
        $form = new ModalForm($title, $message, "§aConfirm", "§cCancel");
        
        $form->setSubmitCallback(function($player, $choice) use ($onConfirm, $onCancel) {
            if ($choice) {
                $onConfirm($player);
            } elseif ($onCancel !== null) {
                $onCancel($player);
            }
        });
        
        return $form;
    }

    public static function infoDialog(string $title, string $message, ?callable $onClose = null): ModalForm {
        $form = new ModalForm($title, $message, "§aOK", "§cClose");
        
        if ($onClose !== null) {
            $form->setSubmitCallback(function($player, $choice) use ($onClose) {
                $onClose($player);
            });
            $form->setCloseCallback($onClose);
        }
        
        return $form;
    }

    public static function menu(string $title, string $description = ""): SimpleForm {
        return new SimpleForm($title, $description);
    }

    public static function settingsForm(string $title): CustomForm {
        return new CustomForm($title);
    }
}
