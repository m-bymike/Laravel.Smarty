<?php

/**
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 *
 * Copyright (c) 2014-2016 Yuuki Takezawa
 *
 */
namespace Ytake\LaravelSmarty\Console;

use Ytake\LaravelSmarty\SmartyFactory;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CacheClearCommand
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class CacheClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ytake:smarty-clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush the Smarty cache';

    /**
     * Execute the console command.
     *
     * @param \Ytake\LaravelSmarty\SmartyFactory $smartyFactory
     * @return int
     */
    public function fire(SmartyFactory $smartyFactory)
    {
        // clear all cache
        if (is_null($this->option('file'))) {
            $smartyFactory->getSmarty()->clearAllCache($this->option('time'));
            $this->info('Smarty cache cleared!');
            return 0;
        }
        // file specified
        if (!$smartyFactory->getSmarty()->clearCache(
            $this->option('file'), $this->option('cache_id'), null, $this->option('time'))
        ) {
            $this->error('specified file not be found');
            return 1;
        }
        $this->info('specified file was cache cleared!');
        return 0;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['file', 'f', InputOption::VALUE_OPTIONAL, 'specify file'],
            ['time', 't', InputOption::VALUE_OPTIONAL, 'clear all of the files that are specified duration time'],
            ['cache_id', 'cache', InputOption::VALUE_OPTIONAL, 'specified cache_id groups'],
        ];
    }
}
