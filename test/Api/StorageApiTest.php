<?php
/**
 * StorageApiTest
 * PHP version 5
 *
 * @category Class
 * @package  Upcloud\ApiClient
 */

/**
 * Upcloud api
 *
 * The UpCloud API consists of operations used to control resources on UpCloud. The API is a web service interface. HTTPS is used to connect to the API. The API follows the principles of a RESTful web service wherever possible. The base URL for all API operations is  https://api.upcloud.com/. All API operations require authentication.
 *
 * OpenAPI spec version: 1.2.0
 *
 */


namespace Upcloud\ApiClient;

use \Upcloud\ApiClient\Configuration;
use \Upcloud\ApiClient\ApiException;
use \Upcloud\ApiClient\ObjectSerializer;
use \Upcloud\ApiClient\Upcloud\StorageApi;
use \Upcloud\ApiClient\Model\Storage;
use \Upcloud\ApiClient\Model\CreateStorageRequest;
use \Upcloud\ApiClient\Model\AttachStorageDeviceRequest;
use \Upcloud\ApiClient\Model\DetachStorageDeviceRequest;
use \Upcloud\ApiClient\Model\BackupRule;
use \Upcloud\ApiClient\Model\StorageTier;
use \Upcloud\ApiClient\Helpers\ServerHelper;

/**
 * StorageApiTest Class Doc Comment
 *
 * @category Class
 * @package  Upcloud\ApiClient
 */
class StorageApiTest extends \PHPUnit_Framework_TestCase
{

    public static $api;
    public static $testStorage;
    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass()
    {
        self::$api = new StorageApi;
        self::$api->getConfig()->setUsername(getenv("UPCLOUD_API_TEST_USER"));
        self::$api->getConfig()->setPassword(getenv("UPCLOUD_API_TEST_PASSWORD"));
    }

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
        $testStorage = ["size" => 10, "tier" => StorageTier::MAXIOPS, "title" => "Test create storage storage", "zone" => "fi-hel1", "backup_rule" => ["interval" =>BackupRule::INTERVAL_DAILY, "time" => "0430", "retention" => 365]];
        self::$testStorage = self::$api->createStorage(new CreateStorageRequest(["storage" => $testStorage]))["storage"];
        // ServerHelper::createReadyServer();
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass()
    {
    }

    /**
     * Test case for attachStorage
     *
     * Attach storage.
     *
     */
    public function testAttachStorage()
    {
        try {
            $serverId = "00b13f6c-0500-4b13-883f-f260bf77542a";
            $storageDevice = ["storage" => self::$testStorage["uuid"], "address" => "scsi:0:0", "type" => "disk"];
            $server = self::$api->attachStorage($serverId, new AttachStorageDeviceRequest(["storage_device" => $storageDevice]))["server"];
            $is = false;
            var_dump($server );
            foreach ($server["storage_devices"]["storage_device"] as $storageDevice) {
                echo $storageDevice["title"];
                if ($storageDevice["title"] === "Test create storage storage") {
                    $is = true;
                }
            }
            $this->assertTrue($is);
            $server = self::$api->detachStorage($serverId, new DetachStorageDeviceRequest(["storage_device"=> ["address" => "scsi:0:0"]]))["server"];
            foreach ($server["storage_devices"]["storage_device"] as $storageDevice) {
                $this->assertNotEquals($storageDevice["address"], "scsi:0:0");
            }
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
        // $this->assertTrue($server["storage_devices"]["storage_device"])
    }

    /**
     * Test case for backupStorage
     *
     * Create backup.
     *
     */
    // public function testBackupStorage()
    // {
    // }

    // /**
    //  * Test case for cancelOperation
    //  *
    //  * Cancel storage operation.
    //  *
    //  */
    // public function testCancelOperation()
    // {
    // }

    // /**
    //  * Test case for cloneStorage
    //  *
    //  * Clone storage.
    //  *
    //  */
    // public function testCloneStorage()
    // {
    // }

    // /**
    //  * Test case for createStorage
    //  *
    //  * Create storage.
    //  *
    //  */
    // public function testCreateStorage()
    // {
    // }

    // /**
    //  * Test case for deleteStorage
    //  *
    //  * Delete storage.
    //  *
    //  */
    // public function testDeleteStorage()
    // {
    // }

    // /**
    //  * Test case for detachStorage
    //  *
    //  * Detach storage.
    //  *
    //  */
    // public function testDetachStorage()
    // {
    // }

    // /**
    //  * Test case for ejectCdrom
    //  *
    //  * Eject CD-ROM.
    //  *
    //  */
    // public function testEjectCdrom()
    // {
    // }

    // /**
    //  * Test case for favoriteStorage
    //  *
    //  * Add storage to favorites.
    //  *
    //  */
    // public function testFavoriteStorage()
    // {
    // }

    // /**
    //  * Test case for getStorageDetails
    //  *
    //  * Get storage details.
    //  *
    //  */
    // public function testGetStorageDetails()
    // {
    // }

    // /**
    //  * Test case for listStorageTypes
    //  *
    //  * List of storages by type.
    //  *
    //  */
    // public function testListStorageTypes()
    // {
    // }

    // /**
    //  * Test case for listStorages
    //  *
    //  * List of storages.
    //  *
    //  */
    // public function testListStorages()
    // {
    // }

    // /**
    //  * Test case for loadCdrom
    //  *
    //  * Load CD-ROM.
    //  *
    //  */
    // public function testLoadCdrom()
    // {
    // }

    // /**
    //  * Test case for modifyStorage
    //  *
    //  * Modify storage.
    //  *
    //  */
    // public function testModifyStorage()
    // {
    // }

    // /**
    //  * Test case for restoreStorage
    //  *
    //  * Restore backup.
    //  *
    //  */
    // public function testRestoreStorage()
    // {
    // }

    // /**
    //  * Test case for templatizeStorage
    //  *
    //  * Templatize storage.
    //  *
    //  */
    // public function testTemplatizeStorage()
    // {
    // }

    // /**
    //  * Test case for unfavoriteStorage
    //  *
    //  * Remove storage from favorites.
    //  *
    //  */
    // public function testUnfavoriteStorage()
    // {
    // }
}
