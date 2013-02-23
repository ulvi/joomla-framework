<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Archive
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for JArchive.
 * Generated by PHPUnit on 2011-10-26 at 19:32:35.
 *
 * @package     Joomla.UnitTest
 * @subpackage  Archive
 *
 * @since       11.1
 */
class JArchiveTest extends PHPUnit_Framework_TestCase
{
	protected static $outputPath;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return mixed
	 */
	protected function setUp()
	{
		parent::setUp();

		self::$outputPath = __DIR__ . '/output';

		if (!is_dir(self::$outputPath))
		{
			mkdir(self::$outputPath, 0777);
		}
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return mixed
	 */
	protected function tearDown()
	{

	}

	/**
	 * Tests extracting ZIP.
	 *
	 * @group    JArchive
	 * @covers    JArchive::extract
	 * @return  void
	 */
	public function testExtractZip()
	{
		if (!is_dir(self::$outputPath))
		{
			$this->markTestSkipped("Couldn't create folder.");

			return;
		}

		if (!JArchiveZip::isSupported())
		{
			$this->markTestSkipped('ZIP files can not be extracted.');

			return;
		}

		JArchive::extract(__DIR__ . '/logo.zip', self::$outputPath);
		$this->assertTrue(is_file(self::$outputPath . '/logo-zip.png'));

		if (is_file(self::$outputPath . '/logo-zip.png'))
		{
			unlink(self::$outputPath . '/logo-zip.png');
		}
	}

	/**
	 * Tests extracting TAR.
	 *
	 * @group    JArchive
	 * @covers    JArchive::extract
	 * @return  void
	 */
	public function testExtractTar()
	{
		if (!is_dir(self::$outputPath))
		{
			$this->markTestSkipped("Couldn't create folder.");

			return;
		}

		if (!JArchiveTar::isSupported())
		{
			$this->markTestSkipped('Tar files can not be extracted.');

			return;
		}

		JArchive::extract(__DIR__ . '/logo.tar', self::$outputPath);
		$this->assertTrue(is_file(self::$outputPath . '/logo-tar.png'));

		if (is_file(self::$outputPath . '/logo-tar.png'))
		{
			unlink(self::$outputPath . '/logo-tar.png');
		}
	}

	/**
	 * Tests extracting gzip.
	 *
	 * @group    JArchive
	 * @covers    JArchive::extract
	 * @return  void
	 */
	public function testExtractGzip()
	{
		if (!is_dir(self::$outputPath))
		{
			$this->markTestSkipped("Couldn't create folder.");

			return;
		}

		if (!is_writable(self::$outputPath) || !is_writable(JFactory::getConfig()->get('tmp_path')))
		{
			$this->markTestSkipped("Folder not writable.");

			return;
		}

		if (!JArchiveGzip::isSupported())
		{
			$this->markTestSkipped('Gzip files can not be extracted.');

			return;
		}

		JArchive::extract(__DIR__ . '/logo.gz', self::$outputPath . '/logo-gz.png');
		$this->assertTrue(is_file(self::$outputPath . '/logo-gz.png'));

		if (is_file(self::$outputPath . '/logo-gz.png'))
		{
			unlink(self::$outputPath . '/logo-gz.png');
		}
	}

	/**
	 * Tests extracting bzip2.
	 *
	 * @group    JArchive
	 * @covers    JArchive::extract
	 * @return  void
	 */
	public function testExtractBzip2()
	{
		if (!is_dir(self::$outputPath))
		{
			$this->markTestSkipped("Couldn't create folder.");

			return;
		}

		if (!is_writable(self::$outputPath) || !is_writable(JFactory::getConfig()->get('tmp_path')))
		{
			$this->markTestSkipped("Folder not writable.");

			return;
		}

		if (!JArchiveBzip2::isSupported())
		{
			$this->markTestSkipped('Bzip2 files can not be extracted.');

			return;
		}

		JArchive::extract(__DIR__ . '/logo.bz2', self::$outputPath . '/logo-bz2.png');
		$this->assertTrue(is_file(self::$outputPath . '/logo-bz2.png'));

		if (is_file(self::$outputPath . '/logo-bz2.png'))
		{
			unlink(self::$outputPath . '/logo-bz2.png');
		}
	}

	/**
	 * Test...
	 *
	 * @covers  JArchive::getAdapter
	 *
	 * @return mixed
	 */
	public function testGetAdapter()
	{
		$zip = JArchive::getAdapter('zip');
		$this->assertInstanceOf('JArchiveZip', $zip);
		$bzip2 = JArchive::getAdapter('bzip2');
		$this->assertInstanceOf('JArchiveBzip2', $bzip2);
		$gzip = JArchive::getAdapter('gzip');
		$this->assertInstanceOf('JArchiveGzip', $gzip);
		$tar = JArchive::getAdapter('tar');
		$this->assertInstanceOf('JArchiveTar', $tar);
	}

	/**
	 * Test...
	 *
	 * @covers  JArchive::getAdapter
	 * @expectedException  UnexpectedValueException
	 *
	 * @return mixed
	 */
	public function testGetAdapterException()
	{
		$zip = JArchive::getAdapter('unknown');
	}
}
