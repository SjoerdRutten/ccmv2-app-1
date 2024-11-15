<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

class CrmFieldCorrectorPersonName extends CrmFieldCorrector
{
    public string $group = 'pattern';

    public string $name = 'Persoonsnaam';

    public ?string $pattern = '^[\p{L}\s\-,\'"\.\\/\\\\]+$';

    public function handle($value, ...$params): mixed
    {
        if ($matches = $this->matchRegex($value)) {
            $oldEncoding = mb_internal_encoding();
            mb_internal_encoding('UTF-8');

            $name = mb_strtolower(trim(\Arr::get($matches, 0)));
            $wordSplitters = [' ', '-'];
            $lowercaseExceptions = ['a', 'aan', 'de', 'den', 'der', 'het', 'af', 'al', 'am', 'auf', 'dem', 'ter', 'aus', 'ben', 'bij', 'bin', 'boven', 'da', 'dal', 'dalla', 'das', 'die', 'la', 'las', 'le', 'van', 'deca', 'degli', 'dei', 'del', 'della', 'des', 'di', 'do', 'don', 'dos', 'du', 'el', 'i', 'im', 'in', 'l', 'les', 'lo', 'los', 'of', 'onder', 'op', 'gen', 'ten', 'over', 's', 'te', 'tho', 'thoe', 'thor', 'to', 'toe', 'tot', 'uijt', 'uit', 'unter', 'ver', 'vom', 'von', 'voor', 'vor', 'zu', 'zum', 'zur', 'ad', 'vd', 't', 'm', 'd', 'v'];
            $uppercaseExceptions = ['ii', 'iii', 'iv', 'vi', 'vii', 'viii', 'ix'];
            $specialExceptions = [
                '^(ij)' => function ($matches) {
                    return strtoupper(\Arr::get($matches, 1));
                },
                '^([d,l])[\‘\’\'\`]([a-z])' => function ($matches) {
                    return strtolower(\Arr::get($matches, 1)).'\''.strtoupper(\Arr::get($matches, 2));
                },
            ];

            foreach ($wordSplitters as $delimiter) {
                $words = explode($delimiter, $name);
                $new_words = [];
                foreach ($words as $word) {
                    if (in_array($word, $uppercaseExceptions)) {
                        $word = mb_strtoupper($word);
                    } elseif (! in_array(preg_replace('/[\‘\’\'\"\`\/\.\\\]/', '', $word), $lowercaseExceptions)) {
                        $word = mb_strtoupper(mb_substr($word, 0, 1)).mb_substr($word, 1);
                    }

                    foreach ($specialExceptions as $pattern => $replacement) {
                        $word = preg_replace_callback('/'.$pattern.'/i', $replacement, $word);
                    }

                    if ($word) {
                        $new_words[] = $word;
                    }
                }

                $name = implode($delimiter, $new_words);
            }

            $name = mb_strtoupper(mb_substr($name, 0, 1)).mb_substr($name, 1);
            mb_internal_encoding($oldEncoding);

            return $name;
        }

        return false;
    }
}
