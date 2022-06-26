<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use UnexpectedValueException;

class ColorValidator extends ConstraintValidator
{
    private const COLORS = [
        'default',
        'yellow',
        'blue',
        'green',
        'red'
    ];

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Color) {
            throw new UnexpectedValueException();
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException();
        }

        if (!in_array($value, self::COLORS)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
