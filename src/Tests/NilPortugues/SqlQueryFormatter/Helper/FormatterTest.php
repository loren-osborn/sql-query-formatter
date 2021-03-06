<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/26/14
 * Time: 9:11 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\NilPortugues\SqlQueryFormatter\Helper;

use NilPortugues\SqlQueryFormatter\Formatter;

/**
 * Class FormatterTest
 * @package Tests\NilPortugues\SqlQueryFormatter\Helper
 */
class FormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $querySeparator = "----------SEPARATOR----------\n";

    /**
     * @var string
     */
    private $expectedResultFilePath = '/Resources/expectedQueries.sql';

    /**
     * @return array
     */
    private function readExpectedQueryFile()
    {
        $expectedQueryArray = explode(
            $this->querySeparator,
            file_get_contents(realpath(dirname(__FILE__)) . $this->expectedResultFilePath)
        );
        $expectedQueryArray = array_filter($expectedQueryArray);

        return $expectedQueryArray;
    }

    /**
     * Data provider reading the test Queries.
     */
    public function sqlQueryDataProvider()
    {
        $expectedQueryArray = $this->readExpectedQueryFile();

        $queryTestSet = array();
        foreach ($expectedQueryArray as $expectedQuery) {
            $queryTestSet[] = array(preg_replace('/\\s+/', ' ', $expectedQuery), $expectedQuery);
        }

        return $queryTestSet;
    }

    /**
     * @test
     * @dataProvider sqlQueryDataProvider
     *
     * @param $notIndented
     * @param $indented
     */
    public function it_should_reformat_no_indent_queries_to_indented_versions($notIndented, $indented)
    {
        $formatter = new Formatter();
        $result = $formatter->format($notIndented);

        $this->assertSame($indented, $result);
    }
}
 