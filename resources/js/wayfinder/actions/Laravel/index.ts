import Horizon from './Horizon'
import Sanctum from './Sanctum'
import Telescope from './Telescope'

const Laravel = {
    Horizon: Object.assign(Horizon, Horizon),
    Sanctum: Object.assign(Sanctum, Sanctum),
    Telescope: Object.assign(Telescope, Telescope),
}

export default Laravel