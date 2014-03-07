<?php

namespace Digitalshift\MailboxConnectionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * MessageMimePartCollection
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessagePartCollection extends ArrayCollection
{
    /**
     * @param string $mimeType
     * @return string
     */
    public function getPartsWithType($mimeType)
    {
        $content = '';

        /** @var \Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePart $mimePart */
        foreach ($this->toArray() as $mimePart) {
            $isHtmlPart = $this->matchesHeaderMimeType(
                $mimePart->getHeader('content-type'),
                array($mimeType)
            );

            $content = ($isHtmlPart) ? $content . $mimePart->decodeContent() : $content;
        }

        return $content;
    }

    /**
     * @param string $mimeType
     * @param array $compareMimeTypes
     * @return bool
     */
    private function matchesHeaderMimeType($mimeType, array $compareMimeTypes)
    {
        $types = $this->getTypeArray($mimeType);

        foreach ($compareMimeTypes as $compareType) {
            $compareTypes = $this->getTypeArray($compareType);

            if (
                $compareTypes['base'] == $types['base'] &&
                (
                    $compareTypes['sub'] == '*' ||
                    $compareTypes['sub'] == $types['sub']
                )
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $type
     * @return array
     */
    private function getTypeArray($type)
    {
        $tmpTypeArray = explode('/', $type);

        return array(
            'base' => $tmpTypeArray[0],
            'sub' => $tmpTypeArray[1]
        );
    }

    /**
     * @param integer $attachmentType
     * @return array
     */
    public function getPartsWithAttachment($attachmentType = MimeMessage::ATTACHMENT_EXTENDED)
    {
        $parts = array();

        /** @var \Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePart $mimePart */
        foreach ($this->toArray() as $mimePart) {
            $isAttachment = $mimePart->isAttachment();
            $typeMatches = $this->matchesHeaderAttachmentType($mimePart, $attachmentType);

            ($isAttachment && $typeMatches) ? $parts[] = $mimePart : null;
        }

        return $parts;
    }

    /**
     * @param MimeMessagePart $mimePart
     * @param integer $expectedAttachmentType
     * @return bool
     */
    private function matchesHeaderAttachmentType(MimeMessagePart $mimePart, $expectedAttachmentType)
    {
        if ($expectedAttachmentType === MimeMessage::ATTACHMENT_EMBEDDED && $mimePart->isHeaderSet('content-disposition')) {
            return true;
        }

        if ($expectedAttachmentType === MimeMessage::ATTACHMENT_EXTENDED && !$mimePart->isHeaderSet('content-disposition')) {
            return true;
        }

        return false;
    }
} 