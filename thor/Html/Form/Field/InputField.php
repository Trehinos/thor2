<?php

/**
 * @package          Thor/Html
 * @copyright (2021) Sébastien Geldreich
 * @license          MIT
 */

namespace Thor\Html\Form\Field;

class InputField extends AbstractField
{

    public function __construct(
        string $name,
        protected string $inputType,
        bool $read_only = false,
        bool $required = false,
        ?string $htmlClass = null,
        ?string $value = null
    ) {
        parent::__construct('input', $name, $value ?? '', $read_only, $required, $htmlClass);
        $this->setAttribute('type', $this->inputType);
    }

}
