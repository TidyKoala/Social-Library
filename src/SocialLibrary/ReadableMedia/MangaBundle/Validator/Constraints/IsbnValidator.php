<?php

namespace SocialLibrary\ReadableMedia\MangaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @see https://en.wikipedia.org/wiki/Isbn
 * @author The Whole Life To Learn <thewholelifetolearn@gmail.com>
 *
 */
class IsbnValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $validation = null;
        $checkIsbn10 = false;
        $checkIsbn13 = false;
        
        if (null === $value || '' === $value) {
            return;
        }
        
        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }
        
        $value = (string) $value;
        $value = strtoupper($value);

        if (!is_int($value)) {
            $value = str_replace('-', '', $value);
        }
        
        if (10 == strlen($value)) {
            for ($i = 0; $i < 10; $i++) {
                if($value[$i] == 'X') {
                    $validation += 10 * intval(10 - $i);
                }
                else {
                    $validation += intval($value[$i]) * intval(10 - $i);
                }
            }
    
            if($validation % 11 == 0) {
                $checkIsbn10 = true;
            }
        }
        
        if (13 == strlen($value)) {
            for ($i = 0; $i < 13; $i+=2) {
                    $validation += intval($value[$i]);
            }
            for ($i = 1; $i < 12; $i+=2) {
                    $validation += intval($value[$i]) * 3;
            }
    
            if($validation % 10 == 0) {
                $checkIsbn13 = true;
            }
        }

        if(null !== $constraint->isbn10 && null !== $constraint->isbn13 && $checkIsbn10 === false && $checkIsbn13 === false) {
            $this->context->addViolation($constraint->bothIsbnMessage);
            return;
        }

        if(null !== $constraint->isbn10 && null === $constraint->isbn13 && $checkIsbn10 === false) {
            $this->context->addViolation($constraint->isbn10Message);
            return;
        }

        if(null !== $constraint->isbn13 && null === $constraint->isbn10 && $checkIsbn13 === false) {
            $this->context->addViolation($constraint->isbn13Message);
        }
    }
}
