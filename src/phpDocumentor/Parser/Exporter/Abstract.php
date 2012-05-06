<?php
/**
 * phpDocumentor
 *
 * PHP Version 5
 *
 * @category  phpDocumentor
 * @package   Parser\Exporter
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2010-2011 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

/**
 * Class responsible for writing the results of the Reflection of a single
 * source file to disk.
 *
 * @category phpDocumentor
 * @package  Parser\Exporter
 * @author   Mike van Riel <mike.vanriel@naenius.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     http://phpdoc.org
 */
abstract class phpDocumentor_Parser_Exporter_Abstract extends phpDocumentor_Parser_Abstract
{
    /** @var \phpDocumentor_Parser */
    protected $parser = null;

    /** @var bool Whether to include the file's source in the export */
    protected $include_source = false;

    abstract public function setTarget($target);

    /**
     * Initializes this exporter.
     *
     * @return void
     */
    public function initialize()
    {

    }

    /**
     * Renders the reflected file to a structure file.
     *
     * @param phpDocumentor_Reflection_File $file File to export.
     *
     * @return void
     */
    abstract public function export(phpDocumentor_Reflection_File $file);

    /**
     * Finalizes this exporter; performs cleaning operations.
     *
     * @return void
     */
    public function finalize()
    {

    }

    /**
     * Save the finalized export if necessary.
     *
     * @return void
     */
    public function write()
    {

    }

    /**
     * Returns the contents of this export or null if contents were directly
     * written to disk.
     *
     * @return string|null
     */
    abstract public function getContents();

    /**
     * Sets whether to include the source in the structure files.
     *
     * @param boolean $include_source
     */
    public function setIncludeSource($include_source)
    {
        $this->include_source = $include_source;
    }

    /**
     * Sets the reference to the parser that's using this exporter.
     *
     * @param phpDocumentor_Parser $parser
     *
     * @return void
     */
    public function setParser(phpDocumentor_Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Returns an instance of an exporter and caches it.
     *
     * @param string $exporter Name of the exporter to get.
     *
     * @return phpDocumentor_Parser_Exporter_Abstract
     */
    public static function getInstanceOf($exporter)
    {
        static $exporters = array();

        if (!class_exists($exporter)) {
            $exporter_class = 'phpDocumentor_Parser_Exporter_'
                . ucfirst($exporter);
        } else {
            $exporter_class = $exporter;
        }

        if (!class_exists($exporter_class)) {
            throw new phpDocumentor_Parser_Exception(
                'Unknown exporter: ' . $exporter_class
            );
        }

        // if there is no exporter in cache; create it
        if (!isset($exporters[strtolower($exporter_class)])) {
            $exporters[strtolower($exporter_class)] = new $exporter_class();
        }

        return $exporters[strtolower($exporter_class)];
    }
}
