<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => false,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'bdk/backtrace' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '2.1',
            ),
        ),
        'bdk/debug' => array(
            'pretty_version' => 'v3.0',
            'version' => '3.0.0.0',
            'reference' => '4c4678234c7fffca5b4ce1ae7bdd345e27e075d1',
            'type' => 'library',
            'install_path' => __DIR__ . '/../bdk/debug',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'bdk/errorhandler' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '3.2',
            ),
        ),
        'bdk/http-message' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '1.0',
            ),
        ),
        'bdk/pubsub' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '2.4',
            ),
        ),
        'psr/http-message' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '1.0.1',
            ),
        ),
    ),
);
