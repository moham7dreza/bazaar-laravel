import Filament from './Filament'
import Monitoring from './Monitoring'
import Payment from './Payment'
import Auth from './Auth'
import Advertise from './Advertise'
import Content from './Content'

const Modules = {
    Filament: Object.assign(Filament, Filament),
    Monitoring: Object.assign(Monitoring, Monitoring),
    Payment: Object.assign(Payment, Payment),
    Auth: Object.assign(Auth, Auth),
    Advertise: Object.assign(Advertise, Advertise),
    Content: Object.assign(Content, Content),
}

export default Modules