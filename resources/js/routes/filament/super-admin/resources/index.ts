import commandPerformanceLogs from './command-performance-logs'
import jobPerformanceLogs from './job-performance-logs'
import paymentGateways from './payment-gateways'
import smsGateways from './sms-gateways'
import smsLogs from './sms-logs'
import users from './users'
import activitylogs from './activitylogs'
import permissions from './permissions'
import roles from './roles'
import monitoredScheduledTasks from './monitored-scheduled-tasks'
import monitoredScheduledTaskLogItems from './monitored-scheduled-task-log-items'
import mails from './mails'
import exceptions from './exceptions'
import locks from './locks'
import folders from './folders'
import media from './media'

const resources = {
    commandPerformanceLogs: Object.assign(commandPerformanceLogs, commandPerformanceLogs),
    jobPerformanceLogs: Object.assign(jobPerformanceLogs, jobPerformanceLogs),
    paymentGateways: Object.assign(paymentGateways, paymentGateways),
    smsGateways: Object.assign(smsGateways, smsGateways),
    smsLogs: Object.assign(smsLogs, smsLogs),
    users: Object.assign(users, users),
    activitylogs: Object.assign(activitylogs, activitylogs),
    permissions: Object.assign(permissions, permissions),
    roles: Object.assign(roles, roles),
    monitoredScheduledTasks: Object.assign(monitoredScheduledTasks, monitoredScheduledTasks),
    monitoredScheduledTaskLogItems: Object.assign(monitoredScheduledTaskLogItems, monitoredScheduledTaskLogItems),
    mails: Object.assign(mails, mails),
    exceptions: Object.assign(exceptions, exceptions),
    locks: Object.assign(locks, locks),
    folders: Object.assign(folders, folders),
    media: Object.assign(media, media),
}

export default resources