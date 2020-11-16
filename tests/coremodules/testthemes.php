<?php

    $suite = new xarTestSuite('Themes module tests');
    $suites[] = $suite;

    class testThemesAdminActivate extends xarTestCase
    {
        public function testActivateNoParams()
        {
            try {
                $this->expected = '[exception]';
                $this->actual   = xarMod::apiFunc('themes', 'admin', 'activate');
                $res = $this->assertSame($this->actual, $this->expected, "Call with no params throws an exception");
                return $res;
            } catch (Exception $e) {
                return $this->assertTrue(true, "Call with no params throws an exception");
            }
        }

        public function testActivate()
        {
            $this->expected = true;
            $this->actual = xarMod::apiFunc('themes', 'admin', 'activate', array('regid' => 21));
            return $this->AssertTrue($this->actual, 'Call with a valid theme id param returns true');
        }

        public function testActivateBadParam()
        {
            try {
                $this->expected = '[exception]';
                $this->actual   = xarMod::apiFunc('themes', 'admin', 'activate', array('regid' => 30073));
                $res = $this->assertSame($this->actual, $this->expected, "Call with an invalid theme id param throws an exception");
                return $res;
            } catch (Exception $e) {
                return $this->assertTrue(true, "Call with an invalid theme id param throws an exception");
            }
        }
    }
    $suite->AddTestCase('testThemesAdminActivate', 'activate (admin) function tests');

    class testThemesAdminGetmenulinks extends xarTestCase
    {
        public function testGetmenulnks()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getmenulinks');
            return $this->AssertTrue(is_array($this->actual), 'Call with no params returns an array');
        }

        public function testGetmenulnksWithParams()
        {
            $args = array('foo' => 'bar');
            $this->expected = xarMod::apiFunc('themes', 'admin', 'getmenulinks');
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getmenulinks', $args);
            return $this->AssertSame($this->actual, $this->expected, 'Call with params returns the same array as without');
        }
    }
    $suite->AddTestCase('testThemesAdminGetmenulinks', 'getMenuLinks (admin) function tests');

    class testThemesAdminCheckMissing extends xarTestCase
    {
        public function testCheckMissing()
        {
            $this->expected = true;
            $this->actual = xarMod::apiFunc('themes', 'admin', 'checkmissing');
            return $this->AssertTrue($this->actual, 'Call with no params returns true');
        }
        
        // More tests needed here
    }
    $suite->AddTestCase('testThemesAdminCheckMissing', 'checkmissing (admin) function tests');

    class testThemesAdminGetDBThemes extends xarTestCase
    {
        public function testGetDBThemes()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getdbthemes');
            return $this->AssertTrue(is_array($this->actual), 'Call with no params returns an array');
        }
    }
    $suite->AddTestCase('testThemesAdminGetDBThemes', 'getdbthemes (admin) function tests');

    class testThemesAdminGetFileThemes extends xarTestCase
    {
        public function testGetFileThemes()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getfilethemes');
            return $this->AssertTrue(is_array($this->actual), 'Call with no params returns an array');
        }
    }
    $suite->AddTestCase('testThemesAdminGetFileThemes', 'getfilethemes (admin) function tests');

    class testThemesAdminGetList extends xarTestCase
    {
        public function testGetList()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getlist');
            return $this->AssertTrue(is_array($this->actual), 'Call with no params returns an array');
        }
        public function testGetListWithParams()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getlist', array(array(),2,3,'class'));
            return $this->AssertTrue(is_array($this->actual), 'Call with valid params returns an array');
        }
        public function testGetListWithBadFilterParam()
        {
            try {
                $this->expected = '[exception]';
                $this->actual   = xarMod::apiFunc('themes', 'admin', 'activate', array('filter' => 'bar'));
                $res = $this->assertSame($this->actual, $this->expected, "Call with an invalid filter  param throws an exception");
                return $res;
            } catch (Exception $e) {
                return $this->assertTrue(true, "Call with an invalid filter param throws an exception");
            }
        }
        public function testGetListWithBadStartnumParam()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getlist', array(array(),'bar',3,'class'));
            return $this->AssertTrue(is_array($this->actual), 'Call with a bad startnum param returns an array?');
        }
        public function testGetListWithBadNumitemsParam()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getlist', array(array(),1,'bar','class'));
            return $this->AssertTrue(is_array($this->actual), 'Call with a bad numitems param returns an array?');
        }
        public function testGetListWithBadOrderParam()
        {
            $this->expected = '[array]';
            $this->actual = xarMod::apiFunc('themes', 'admin', 'getlist', array(array(),2,3,'foobar'));
            return $this->AssertTrue(is_array($this->actual), 'Call with a bad order param returns an array?');
        }
    }
    $suite->AddTestCase('testThemesAdminGetList', 'getlist (admin) function tests');
