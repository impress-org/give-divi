<?php

namespace GiveDivi\Tests;

use Give\Tests\TestCase;

use GiveDivi\Addon\Environment;

/**
 * @since 2.0.0
 */
class TestGiveDivi extends TestCase
{
    /**
     * @since 2.0.0
     */
    public function testReadMeVersionMatchesPluginVersion(): void
    {
        $readme = get_file_data(
            trailingslashit(GIVE_DIVI_ADDON_DIR) . "readme.txt",
            [
                "Version" => "Stable tag"
            ]
        );

        $plugin = get_plugin_data(GIVE_DIVI_ADDON_FILE);

        $this->assertEquals(GIVE_DIVI_ADDON_VERSION, $readme['Version']);
        $this->assertEquals(GIVE_DIVI_ADDON_VERSION, $plugin['Version']);
        $this->assertEquals($readme['Version'], $plugin['Version']);
    }

    /**
     * @since 2.0.0
     */
    public function testHasMinimumGiveWPVersion(): void
    {
        $this->assertSame('3.0.0', GIVE_DIVI_ADDON_MIN_GIVE_VERSION);
    }

    /**
     * @since 2.0.0
     */
    public function testIsCompatibleWithGiveWP(): void
    {
        $this->assertFalse(version_compare(GIVE_VERSION, GIVE_DIVI_ADDON_MIN_GIVE_VERSION, '<'));
    }

    /**
     * @since 2.0.0
     */
    public function testCheckRequirementsShouldReturnTrue(): void
    {
        $this->assertTrue(Environment::giveMinRequiredVersionCheck());
    }

    /**
     * @since 2.0.0
     */
    public function testReadMeRequiresPHPVersionMatchesPluginVersion(): void
    {
        $readme = get_file_data(
            trailingslashit(GIVE_DIVI_ADDON_DIR) . "readme.txt",
            [
                "RequiresPHP" => "Requires PHP"
            ]
        );

        $plugin = get_plugin_data(GIVE_DIVI_ADDON_FILE);

        $this->assertEquals($plugin['RequiresPHP'], $readme['RequiresPHP']);
    }

    /**
     * @since 2.0.0
     */
    public function testReadMeRequiresWPVersionMatchesPluginHeaderVersion(): void
    {
        $readme = get_file_data(
            trailingslashit(GIVE_DIVI_ADDON_DIR) . "readme.txt",
            [
                "RequiresWP" => "Requires at least"
            ]
        );

        $plugin = get_plugin_data(GIVE_DIVI_ADDON_FILE);

        $this->assertEquals($plugin['RequiresWP'], $readme['RequiresWP']);
    }
}
