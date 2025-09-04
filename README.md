# blibio/combinatorics

[![Software License][badge-license]][license]
[![Coverage Status][badge-coverage]][coverage]

Simple PHP 8.3+ [generators][] to create:

- [combinations][] with or without repetition and 
- [permutations][] with or without repetition.

---

#### Usage

To use the generators, simply create the kind of object you need, and iterate. E.g.:

````php
<?php
declare(strict_types=1);

use Blibio\Combinatorics\Combinatorics;

$elements = ['A', 'B', 'C', 'D'];
$k = 3;
$it = Combinatorics::combinationsWithoutRepetition($elements, $k);

// or:
// $it = Combinatorics::combinationsWithRepetition($elements, $k);
// $it = Combinatorics::permutationsWithoutRepetition($elements, $k);
// $it = Combinatorics::permutationsWithRepetition($elements, $k);

foreach ($it as $set) {
    // use $set
}
````

## Copyright and license

The blibio/combinatorics library is copyright © Stephan Six and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.

[generators]: https://php.net/manual/language.generators.overview.php
[combinations]: https://en.wikipedia.org/wiki/Combination
[permutations]: https://en.wikipedia.org/wiki/Permutation
[badge-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[badge-coverage]: https://codecov.io/gh/blibio/combinatorics/branch/main/graph/badge.svg
[license]: https://github.com/blibio/combinatorics/blob/main/LICENSE
[coverage]: https://codecov.io/gh/blibio/combinatorics
