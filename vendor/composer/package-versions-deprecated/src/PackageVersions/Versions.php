<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'aurel/simple-mvc';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'symfony/polyfill-ctype' => 'v1.20.0@f4ba089a5b6366e453971d3aad5fe8e897b37f41',
  'symfony/polyfill-mbstring' => 'v1.20.0@39d483bdf39be819deabf04ec872eb0b2410b531',
  'twig/twig' => 'v3.1.1@b02fa41f3783a2616eccef7b92fbc2343ffed737',
  'amphp/amp' => 'v2.5.1@ecdc3c476b3ccff02f8e5d5bcc04f7ccfd18751c',
  'amphp/byte-stream' => 'v1.8.0@f0c20cf598a958ba2aa8c6e5a71c697d652c7088',
  'amphp/parallel' => 'v1.4.0@2c1039bf7ca137eae4d954b14c09a7535d7d4e1c',
  'amphp/parallel-functions' => 'v0.1.3@12e6c602e067b02f78ddf5b720c17e9aa01ad4b4',
  'amphp/parser' => 'v1.0.0@f83e68f03d5b8e8e0365b8792985a7f341c57ae1',
  'amphp/process' => 'v1.1.0@355b1e561b01c16ab3d78fada1ad47ccc96df70e',
  'amphp/serialization' => 'v1.0.0@693e77b2fb0b266c3c7d622317f881de44ae94a1',
  'amphp/sync' => 'v1.4.0@613047ac54c025aa800a9cde5b05c3add7327ed4',
  'composer/package-versions-deprecated' => '1.11.99@c8c9aa8a14cc3d3bec86d0a8c3fa52ea79936855',
  'composer/xdebug-handler' => '1.4.4@6e076a124f7ee146f2487554a94b6a19a74887ba',
  'doctrine/collections' => '1.6.7@55f8b799269a1a472457bd1a41b4f379d4cfba4a',
  'filp/whoops' => '2.9.1@307fb34a5ab697461ec4c9db865b20ff2fd40771',
  'gitonomy/gitlib' => 'v1.2.2@d1fe4676bf1347c08dec84a14a4c5e7110740d72',
  'jean85/pretty-package-versions' => '1.5.1@a917488320c20057da87f67d0d40543dd9427f7a',
  'monolog/monolog' => '2.1.1@f9eee5cec93dfb313a38b6b288741e84e53f02d5',
  'nette/bootstrap' => 'v3.0.2@67830a65b42abfb906f8e371512d336ebfb5da93',
  'nette/di' => 'v3.0.5@766e8185196a97ded4f9128db6d79a3a124b7eb6',
  'nette/finder' => 'v2.5.2@4ad2c298eb8c687dd0e74ae84206a4186eeaed50',
  'nette/neon' => 'v3.2.1@a5b3a60833d2ef55283a82d0c30b45d136b29e75',
  'nette/php-generator' => 'v3.5.1@fe54415cd22d01bee1307a608058bf131978610a',
  'nette/robot-loader' => 'v3.3.1@15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b',
  'nette/schema' => 'v1.0.2@febf71fb4052c824046f5a33f4f769a6e7fa0cb4',
  'nette/utils' => 'v3.1.3@c09937fbb24987b2a41c6022ebe84f4f1b8eec0f',
  'nikic/php-parser' => 'v4.10.2@658f1be311a230e0907f5dfe0213742aff0596de',
  'ondram/ci-detector' => '3.5.1@594e61252843b68998bddd48078c5058fe9028bd',
  'opis/closure' => '3.6.1@943b5d70cc5ae7483f6aff6ff43d7e34592ca0f5',
  'pdepend/pdepend' => '2.8.0@c64472f8e76ca858c79ad9a4cf1e2734b3f8cc38',
  'phpmd/phpmd' => '2.9.1@ce10831d4ddc2686c1348a98069771dd314534a8',
  'phpro/grumphp' => 'v1.1.0@8c0b39169ea83e6c7bdd3573ba351dd0d52a42fa',
  'phpstan/phpdoc-parser' => '0.3.5@8c4ef2aefd9788238897b678a985e1d5c8df6db4',
  'phpstan/phpstan' => '0.11.20@938dcc03a005280e1a9587ec7684345bff06ebfc',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc',
  'seld/jsonlint' => '1.8.2@590cfec960b77fd55e39b7d9246659e95dd6d337',
  'squizlabs/php_codesniffer' => '3.5.8@9d583721a7157ee997f235f327de038e7ea6dac4',
  'symfony/config' => 'v5.1.8@11baeefa4c179d6908655a7b6be728f62367c193',
  'symfony/console' => 'v4.4.16@20f73dd143a5815d475e0838ff867bce1eebd9d5',
  'symfony/dependency-injection' => 'v5.1.8@829ca6bceaf68036a123a13a979f3c89289eae78',
  'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665',
  'symfony/dotenv' => 'v5.1.8@29ac2a3e538da61780a769827c716738ce7accbb',
  'symfony/event-dispatcher' => 'v4.4.16@4204f13d2d0b7ad09454f221bb2195fccdf1fe98',
  'symfony/event-dispatcher-contracts' => 'v1.1.9@84e23fdcd2517bf37aecbd16967e83f0caee25a7',
  'symfony/filesystem' => 'v5.1.8@df08650ea7aee2d925380069c131a66124d79177',
  'symfony/finder' => 'v4.4.16@26f63b8d4e92f2eecd90f6791a563ebb001abe31',
  'symfony/options-resolver' => 'v5.1.8@c6a02905e4ffc7a1498e8ee019db2b477cd1cc02',
  'symfony/polyfill-php73' => 'v1.20.0@8ff431c517be11c78c48a39a66d37431e26a6bed',
  'symfony/polyfill-php80' => 'v1.20.0@e70aa8b064c5b72d3df2abd5ab1e90464ad009de',
  'symfony/process' => 'v5.1.8@f00872c3f6804150d6a0f73b4151daab96248101',
  'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1',
  'symfony/yaml' => 'v5.1.8@f284e032c3cefefb9943792132251b79a6127ca6',
  'aurel/simple-mvc' => 'dev-master@a42cde18ae71f91f841429e67c82f3ca19c61e04',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
