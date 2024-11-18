<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Pattern;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorInitials extends CrmFieldCorrector
{
    public string $group = 'pattern';

    public string $name = 'Initialen';

    public ?string $pattern = '^[\p{L}\s.-]+$';

    public function handle($value, ...$params): mixed
    {
        if ($matches = $this->matchRegex($value)) {
            $oldEncoding = mb_internal_encoding();
            mb_internal_encoding('UTF-8');

            $initials = mb_strtolower(trim(\Arr::get($matches, 0)));
            $known_initials = ['adr', 'chr', 'fr', 'fred', 'ij', 'jac', 'joh', 'ph', 'st', 'th', 'tj'];
            $word_splitters = ['-', ' ', '.']; // The dot needs to be last value in array.

            foreach ($word_splitters as $delimiter) {
                $words = explode($delimiter, $initials);
                $new_words = [];
                foreach ($words as $word) {
                    if ($word) {
                        $word = mb_strtolower($word);
                        if (in_array($word, $known_initials)) {
                            $new_words[] = mb_strtoupper(mb_substr($word, 0, 1)).mb_substr($word, 1);
                        } elseif (preg_match('/'.implode('|', array_map('preg_quote', $word_splitters)).'/i', $word)) {
                            $new_words[] = $word;
                        } else {
                            $new_words = array_merge($new_words, preg_split('/(?<!^)(?!$)/u', mb_strtoupper($word)));
                        }
                    }
                }
                $initials = implode(end($word_splitters), $new_words);
            }

            mb_internal_encoding($oldEncoding);

            return $initials.'.';
        }

        return false;
    }
}
