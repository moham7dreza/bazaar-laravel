import FilamentPWA from './FilamentPWA'
import FilamentSettingsHub from './FilamentSettingsHub'
import FilamentMediaManager from './FilamentMediaManager'

const TomatoPHP = {
    FilamentPWA: Object.assign(FilamentPWA, FilamentPWA),
    FilamentSettingsHub: Object.assign(FilamentSettingsHub, FilamentSettingsHub),
    FilamentMediaManager: Object.assign(FilamentMediaManager, FilamentMediaManager),
}

export default TomatoPHP