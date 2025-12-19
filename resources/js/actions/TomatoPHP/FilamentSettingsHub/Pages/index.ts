import SiteSettings from './SiteSettings'
import SocialMenuSettings from './SocialMenuSettings'
import LocationSettings from './LocationSettings'
import SettingsHub from './SettingsHub'

const Pages = {
    SiteSettings: Object.assign(SiteSettings, SiteSettings),
    SocialMenuSettings: Object.assign(SocialMenuSettings, SocialMenuSettings),
    LocationSettings: Object.assign(LocationSettings, LocationSettings),
    SettingsHub: Object.assign(SettingsHub, SettingsHub),
}

export default Pages