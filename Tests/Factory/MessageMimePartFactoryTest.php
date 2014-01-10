<?php

namespace Digitalshift\MailboxClientBundle\Tests\Factory;

use Digitalshift\MailboxClientBundle\Factory\MessageMimePartFactory;
use Digitalshift\MailboxClientBundle\Tests\BaseTestCase;
use Digitalshift\MailboxClientBundle\Tests\Mocks\MessageHeaderFactoryMock;

/**
 * MessageMimePartFactoryTest
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageMimePartFactoryTest extends BaseTestCase
{
    const FIXTURE_PATH = '../Fixtures/RawMessage/';
    const MIME_PART_PATH = '../Fixtures/RawMessage/';

    /**
     * @dataProvider byRawContentProvider
     *
     * @param string $rawContent
     * @param array $expectedParts
     */
    public function testByRawContent($rawContent, $expectedParts)
    {
        $messageMimePartFactory = $this->getMessageMimePartFactory();
        $mimePartCollection = $messageMimePartFactory->byRawContent($rawContent);

        foreach ($expectedParts as $key => $expectedValue) {
            $mimePartValue = $mimePartCollection->get($key);
            $this->assertEquals($expectedValue, $mimePartValue->getContent());
        }
    }

    /**
     * @return array
     */
    public function byRawContentProvider()
    {
        return array(
            array(
                $this->getMailRawContent(__DIR__.'/'.self::FIXTURE_PATH.'message1_body'),
                array(
                    '1' => $this->loadMimePartContent('message1_body_part_1')
                )
            ),
            array(
                $this->getMailRawContent(__DIR__.'/'.self::FIXTURE_PATH.'message2_body'),
                array(
                    '1' => $this->loadMimePartContent('message2_body_part_1'),
                    '1.1' => $this->loadMimePartContent('message2_body_part_1_1'),
                    '1.2' => $this->loadMimePartContent('message2_body_part_1_2'),
                    '1.2.1' => $this->loadMimePartContent('message2_body_part_1_2_1'),
                    '1.2.2' => $this->loadMimePartContent('message2_body_part_1_2_2'),
                    '1.2.3' => $this->loadMimePartContent('message2_body_part_1_2_3'),
                    '1.2.4' => $this->loadMimePartContent('message2_body_part_1_2_4'),
                    '1.2.5' => $this->loadMimePartContent('message2_body_part_1_2_5'),
                )
            ),
        );
    }

    /**
     * @return MessageMimePartFactory
     */
    private function getMessageMimePartFactory()
    {
        return new MessageMimePartFactory();
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function loadMimePartContent($fileName)
    {
        return $this->getMailRawContent(__DIR__.'/'.self::MIME_PART_PATH.$fileName);
    }
} 