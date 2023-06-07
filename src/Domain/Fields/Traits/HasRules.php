<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Fields\Traits;

use Dystcz\Flow\Domain\Flows\Enums\ValidationStrategy;
use Dystcz\Flow\Domain\Flows\Facades\Flow;

trait HasRules
{
    public array $rules = [];

    public array $messages = [];

    /**
     * Set the validation rules that apply to the request.
     */
    public function rules(array $rules): self
    {
        // If flow is set to loose validation
        if (Flow::validationStrategy() === ValidationStrategy::LOOSE) {

            // Add nullable rule
            $rules = array_merge($rules, ['nullable']);

            // Mark fields as loosely required
            if (in_array('required', $rules) && ! in_array(ValidationStrategy::STRICT->value, $rules)) {
                $rules = array_merge($rules, [ValidationStrategy::LOOSE->value]);
            }
        }

        $this->rules = $rules;

        return $this;
    }

    /**
     * Check if field is considered complete without checking if the value was saved.
     */
    public function preconsideredComplete(bool $strict = false): bool
    {
        // If we are in strict mode, we have to check value
        if ($strict || in_array('required', $this->getRules())) {
            return false;
        }

        // If field is set to loose validation, we can consider the field complete without checking value
        if (in_array('loose', $this->getRules())) {
            return true;
        }

        return true;
    }

    /**
     * Get validation rules.
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Set custom messages for validator errors.
     */
    public function messages(array $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get custom messages.
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
