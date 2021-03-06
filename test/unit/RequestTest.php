<?php

class RequestTest extends PHPUnit_Framework_TestCase {

    public function testExtractsId() {
        $this->assertEquals('12345zx', self::request('/12345zx.jpg')->id);
        $this->assertEquals('12345zx', self::request('/12345zx')->id);
    }

    public function testExtractsGroup() {
        $this->assertEquals(
            'adm',
            self::request('/adm/12345zx.jpg')->group
        );
    }

    public function testUnderstandsOutputContentTypeByExtension() {
        $this->assertEquals(
            ContentType::jpeg(),
            self::request('/12345zx.jpg')->contentType
        );
    }

    public function testExtractsCommandStringFromUri() {
        $r = self::request('/123erwe34_175x75_bgFFF_bw.jpg');
        $this->assertEquals('175x75_bgFFF_bw', $r->commandString);
    }

    public function testExtractsAll() {
        $r = self::request('/adm/123erwe34_175x75_bgFFF_bw.jpg');
        $this->assertEquals('adm', $r->group);
        $this->assertEquals('123erwe34', $r->id);
        $this->assertEquals('175x75_bgFFF_bw', $r->commandString);
        $this->assertEquals(ContentType::jpeg(), $r->contentType);
    }

    public function testProvidesAccessToPostedFile() {
        $request = new Request('', array('content' => '123', 'filename' => 'Text.txt'));
        $this->assertEquals('123', $request->bin);
        $this->assertEquals('Text.txt', $request->postedFilename);
    }

    public function testKeepsOriginalUri() {
        $r = self::request('/adm/123erwe34_absrs.jpg');
        $this->assertEquals('123erwe34_absrs.jpg', $r->originalBasename);
    }

    public function testKeepsOriginalUriOfGroupRequest() {
        $r = self::request('/123erwe34_absrs.jpg');
        $this->assertEquals('123erwe34_absrs.jpg', $r->originalBasename);
    }

    public function testRecognizesCommandWhenExtensionMissed() {
        $r = self::request('/123erwe34_absrs');
        $this->assertEquals('absrs', $r->commandString);
    }

//--------------------------------------------------------------------------------------------------

    private static function request($uri) {
        return new Request($uri);
    }
}
