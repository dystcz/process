<?php

namespace Dystcz\Flow\Domain\Flows\Enums;

enum StepStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case FINISHED = 'finished';
    case HOLD = 'hold';

    /**
     * Get status label.
     */
    public function label(): string
    {
        return match ($this) {
            self::OPEN => __('enums.steps.status.open'),
            self::CLOSED => __('enums.steps.status.closed'),
            self::FINISHED => __('enums.steps.status.finished'),
            self::HOLD => __('enums.steps.status.hold'),
        };
    }
}