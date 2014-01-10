<?php

namespace Digitalshift\MailboxClientBundle\Tests\Factory;

use Digitalshift\MailboxClientBundle\Factory\MessageHeaderFactory;
use Digitalshift\MailboxClientBundle\Mailbox\MessageMimePart;
use Digitalshift\MailboxClientBundle\Tests\BaseTestCase;

/**
 * MessageHeaderFactoryTest
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MessageHeaderFactoryTest extends BaseTestCase
{
    const FIXTURE_PATH = '../Fixtures/Message/';

    /**
     * @dataProvider mailProvider
     *
     * @param $rawContent
     * @param $headers
     */
    public function testByRawContent($rawContent, $headers)
    {
        $messageHeaderFactory = $this->getMessageHeaderFactory();
        $header = $messageHeaderFactory->byRawContent($rawContent);

        foreach ($headers as $key => $value) {
            $headerValue = $header->get($key);
            $this->assertEquals($value, $headerValue);
        }
    }

    /**
     * @return array
     */
    public function mailProvider()
    {
        return array(
            array(
                $this->getMailRawContent(__DIR__.'/'.self::FIXTURE_PATH.'message1_header'),
                array(
                    'Return-Path' => '<return-address@mail-account.com>',
                    'Delivered-To' => 'receiver@mail-account.com',
                    'Received' => 'from acme.fritz.box (unknown [XXX.XXX.XXX.XXX]) (Authenticated sender: receiver@mail-account.com) by mail-account.com (Postfix) with ESMTPSA id 0FCCB80ED for <return-address@mail-account.com>; Fri, 10 Jan 2014 08:03:21 +0000 (UTC)',
                    'From' => 'Sender <sender@mail-account.com>',
                    'Content-Type' => 'text/plain; charset=us-ascii',
                    'Content-Transfer-Encoding' => 'quoted-printable',
                    'Subject' => 'Fixture-Message-1',
                    'Message-Id' => '<23B7774D-847F-4A11-A1B0-3B5E055E4499@mail-account.com>',
                    'Date' => 'Fri, 10 Jan 2014 09:03:22 +0100',
                    'To' => 'receiver@mail-account.com',
                    'Mime-Version' => '1.0 (Mac OS X Mail 7.1 \(1827\))',
                    'X-Mailer' => 'Apple Mail (2.1827)'
                )
            ),
            array(
                $this->getMailRawContent(__DIR__.'/'.self::FIXTURE_PATH.'message2_header'),
                array(
                    'Return-Path' => '<sender-adress@mail-account.com>',
                    'Delivered-To' => 'receiver@mail-account.com',
                    'Received' => array(
                        'from localhost (localhost [XXX.XXX.XXX.XXX]) by mail-account.com (Postfix) with ESMTP id D38FB815A for <receiver@mail-account.com>; Fri, 10 Jan 2014 14:35:48 +0100 (CET)',
                        'from mail-account.com ([XXX.XXX.XXX.XXX]) by localhost (mail-account.com [XXX.XXX.XXX.XXX]) (amavisd-new, port 10024) with ESMTP id uqTZxkT7pOpb for <receiver@mail-account.com>; Fri, 10 Jan 2014 14:35:46 +0100 (CET)',
                        'from mail-ea0-f171.mail-account.com (mail-account.com [XXX.XXX.XXX.XXX]) by mail-account.com (Postfix) with ESMTPS for <receiver@mail-account.com>; Fri, 10 Jan 2014 14:35:46 +0100 (CET)',
                        'from host (mail-account.com. [XXX.XXX.XXX.XXX]) by mail-account.com with ESMTPSA id m1sm14601375eeg.0.2014.01.10.05.35.42 for <receiver@mail-account.com> (version=TLSv1 cipher=ECDHE-RSA-RC4-SHA bits=128/128); Fri, 10 Jan 2014 05:35:43 -0800 (PST)',
                    ),
                    'X-Virus-Scanned' => 'amavisd-new at mail-account.com',
                    'X-Spam-Flag' => 'NO',
                    'X-Spam-Score' => '-0.797',
                    'X-Spam-Status' => 'No, score=-0.797 tagged_above=-1000 required=5 tests=[DKIM_SIGNED=0.1, DKIM_VALID=-0.1, DKIM_VALID_AU=-0.1, FREEMAIL_FROM=0.001, HTML_MESSAGE=0.001, RCVD_IN_DNSWL_LOW=-0.7, TVD_SPACE_RATIO=0.001] autolearn=ham',
                    'Authentication-Results' => 'mail-account.com (amavisd-new); dkim=pass (2048-bit key) header.d=domain.com',
                    'From' => '"Sender" <sender@mail-account.com>',
                    'Content-Type' => 'multipart/signed; boundary="Apple-Mail=_641813DC-9FCE-4DB2-BC8C-1AD730E94889"; protocol="application/pgp-signature"; micalg=pgp-sha1',
                    'Subject' => 'Fixture-Message-2',
                    'Message-Id' => '<852AC7B4-541B-4293-BF8D-9F4664BDA97C@mail-account.com>',
                    'Date' => 'Fri, 10 Jan 2014 14:35:38 +0100',
                    'To' => 'receiver@mail-account.com',
                    'Mime-Version' => '1.0 (Mac OS X Mail 7.1 \(1827\))',
                    'X-Mailer' => 'Apple Mail (2.1827)'
                )
            ),
        );
    }

    /**
     * @dataProvider arrayProvider
     *
     * @param $array
     * @param $headers
     */
    public function testByArray($array, $headers)
    {
        $messageHeaderFactory = $this->getMessageHeaderFactory();
        $header = $messageHeaderFactory->byRawContent($array);

        foreach ($headers as $key => $value) {
            $headerValue = $header->get($key);

            $this->assertTrue($headerValue);
            $this->assertEquals($value, $headerValue);
        }
    }

    /**
     * @todo: provide testcase data
     *
     * @return array
     */
    public function arrayProvider()
    {
        return array(
            array(array(), array()),
            array(array(), array()),
            array(array(), array()),
        );
    }

    /**
     * @dataProvider mimePartProvider
     *
     * @param MessageMimePart $mimePart
     * @param array $headers
     */
    public function testByMimePart(MessageMimePart $mimePart, $headers)
    {
        $messageHeaderFactory = $this->getMessageHeaderFactory();
        $header = $messageHeaderFactory->byRawContent($mimePart);

        foreach ($headers as $key => $value) {
            $headerValue = $header->get($key);

            $this->assertTrue($headerValue);
            $this->assertEquals($value, $headerValue);
        }
    }

    /**
     * @todo: provide testcase data
     *
     * @return array
     */
    public function mimePartProvider()
    {
        return array(
            array(new MessageMimePart(array()), array()),
            array(new MessageMimePart(array()), array()),
            array(new MessageMimePart(array()), array()),
        );
    }

    /**
     * @return MessageHeaderFactory
     */
    private function getMessageHeaderFactory()
    {
        return new MessageHeaderFactory();
    }
} 