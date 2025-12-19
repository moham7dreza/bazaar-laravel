import MailResource from './MailResource'
import EventResource from './EventResource'
import SuppressionResource from './SuppressionResource'

const Resources = {
    MailResource: Object.assign(MailResource, MailResource),
    EventResource: Object.assign(EventResource, EventResource),
    SuppressionResource: Object.assign(SuppressionResource, SuppressionResource),
}

export default Resources