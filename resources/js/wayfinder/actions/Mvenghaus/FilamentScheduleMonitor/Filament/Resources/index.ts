import MonitoredScheduledTaskResource from './MonitoredScheduledTaskResource'
import MonitoredScheduledTaskLogItemResource from './MonitoredScheduledTaskLogItemResource'

const Resources = {
    MonitoredScheduledTaskResource: Object.assign(MonitoredScheduledTaskResource, MonitoredScheduledTaskResource),
    MonitoredScheduledTaskLogItemResource: Object.assign(MonitoredScheduledTaskLogItemResource, MonitoredScheduledTaskLogItemResource),
}

export default Resources