<?php

namespace XmlValidator;

class XmlValidator
{

    /**
     * @var Array of \Error
     */
    public $errors;

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function validate($xml, $schema)
    {
        if ('' === trim($xml)) {
            throw new \InvalidArgumentException(sprintf('File %s does not contain valid XML, it is empty.', $xml));
        }

        $internalErrors = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(true);
        libxml_clear_errors();

        $dom = new \DOMDocument();
        $dom->validateOnParse = true;
        if (!$dom->loadXML($xml, LIBXML_NONET | (defined('LIBXML_COMPACT') ? LIBXML_COMPACT : 0))) {
            libxml_disable_entity_loader($disableEntities);
            $this->errors = $this->getXmlErrors($internalErrors);
            return false;
        }

        $dom->normalizeDocument();

        libxml_use_internal_errors($internalErrors);
        libxml_disable_entity_loader($disableEntities);

        foreach ($dom->childNodes as $child) {
            if ($child->nodeType === XML_DOCUMENT_TYPE_NODE) {
                throw new \InvalidArgumentException('Document types are not allowed.');
            }
        }

        if (null !== $schema) {
            $internalErrors = libxml_use_internal_errors(true);
            libxml_clear_errors();

            $e = null;
            if (!is_array($schema) && is_file((string) $schema)) {
                $valid = @$dom->schemaValidate($schema);
            } else {
                libxml_use_internal_errors($internalErrors);

                throw new \InvalidArgumentException('The schema argument has to be a valid path to XSD file or callable.');
            }

            if (!$valid) {
                $messages = $this->getXmlErrors($internalErrors);
                if (empty($messages)) {
                    $messages = array(sprintf('The XML "%s" is not valid.', $xml));
                }
                throw new \InvalidArgumentException(implode("\n", $messages), 0, $e);
            }
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return true;
    }

    private function getXmlErrors($internalErrors)
    {
        $errors = array();
        foreach (libxml_get_errors() as $error) {
            $errors[] = new Error(
                LIBXML_ERR_WARNING == $error->level ? 'WARNING' : 'ERROR',
                $error->code,
                trim($error->message),
                $error->file ? $error->file : 'n/a',
                $error->line,
                $error->column
            );
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return $errors;
    }

    public function isValid(){
        return !$this->getErrors();
    }
}
