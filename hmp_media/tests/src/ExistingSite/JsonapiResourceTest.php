<?php

namespace Drupal\Tests\hmp_media\ExistingSite;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Vocabulary;
use Drupal\Tests\jsonapi\Functional\JsonApiRequestTestTrait;
use GuzzleHttp\RequestOptions;
use weitzman\DrupalTestTraits\Entity\NodeCreationTrait;
use weitzman\DrupalTestTraits\Entity\TaxonomyCreationTrait;
use weitzman\DrupalTestTraits\ExistingSiteBase;
/**
 * Test the JSON
 *
 * @group hmp_media
 */
class JsonapiResourceTest extends ExistingSiteBase {

  use JsonApiRequestTestTrait;

  /**
   * The jsonapi url to run tests on.
   *
   * @var \Drupal\Core\Url
   */
  protected $jsonApiUrl;

  /**
   * An array of uuids in the correct oder.
   *
   * @var array
   */
  protected $correctOrderUuids;

  /**
   * Set up content and taxonomy terms to test with.
   */
  protected function setUp(): void {
    parent::setUp();
    $this->jsonApiUrl = Url::fromUri('internal:/jsonapi/featured-content', ['query' => ['page[limit]' => 4]]);
  }

  public function testJsonResponse() {
    $this->assertJsonResponse();
  }

  /**
   * Asserts the jsonapi response.
   *
   */
  protected function assertJsonResponse() {
    $request_options = [];
    $request_options[RequestOptions::HEADERS]['Accept'] = 'application/vnd.api+json';
    $response = $this->request('GET', $this->jsonApiUrl, $request_options);
    $this->assertSame(200, $response->getStatusCode());
    $response_document = Json::decode((string) $response->getBody());
    /* 
    foreach ($response_document['data'] as $item) {
      $this->assertEquals($correct_order_uuids, array_map(static function (array $data) {
        return $data['id'];
      }, $response_document['data']));
    }
    */
  }
}
