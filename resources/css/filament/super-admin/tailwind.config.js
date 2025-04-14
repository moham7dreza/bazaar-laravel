import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/bezhansalleh/filament-language-switch/resources/views/language-switch.blade.php',
        './vendor/cmsmaxinc/filament-system-versions/resources/**/*.blade.php',
        './vendor/awcodes/overlook/resources/**/*.blade.php',
    ],
}
