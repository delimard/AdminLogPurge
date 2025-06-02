<?php

namespace AdminLogPurge\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class AdminLogPurgeForm
 * @package AdminLogPurge\Form
 */
class AdminLogPurgeForm extends BaseForm
{
    // The date format for the start date
    public const PHP_DATE_FORMAT = "Y-m-d H:i:s";
    public const MOMENT_JS_DATE_FORMAT = "YYYY-MM-DD HH:mm:ss";

    /**
     * @return void
     */
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add('start_date', TextareaType::class,
                [
                    'label' => Translator::getInstance()->trans('Remove older logs from this date', [],  'adminlogpurge'),
                    'required' => true,
                    'constraints' => [
                        new Constraints\NotBlank(),
                        new Constraints\Callback([
                            "callback" => [$this, "checkDate"],
                        ])
                    ]
                ]
                        );
            
    }

    /**
     * Validate a date entered with the current edition Language date format.
     *
     * @param string $value
     * @param ExecutionContextInterface $context
     */
    public function checkDate(string $value, ExecutionContextInterface $context): void
    {
        if (! empty($value) && false === \DateTime::createFromFormat(self::PHP_DATE_FORMAT, $value)) {
            $context->addViolation(
                Translator::getInstance()->trans(
                    "Date '%date' is invalid, please enter a valid date using %fmt format",
                    [
                        '%date' => $value,
                        '%fmt' => self::MOMENT_JS_DATE_FORMAT
                    ],
                    'adminlogpurge'
                )
            );
        }
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'adminlogpurge_form';
    }
}