import CommandPerformanceLogResource from './CommandPerformanceLogResource'
import JobPerformanceLogResource from './JobPerformanceLogResource'
import PaymentGatewayResource from './PaymentGatewayResource'
import SmsGatewayResource from './SmsGatewayResource'
import SmsLogResource from './SmsLogResource'
import UserResource from './UserResource'

const Resources = {
    CommandPerformanceLogResource: Object.assign(CommandPerformanceLogResource, CommandPerformanceLogResource),
    JobPerformanceLogResource: Object.assign(JobPerformanceLogResource, JobPerformanceLogResource),
    PaymentGatewayResource: Object.assign(PaymentGatewayResource, PaymentGatewayResource),
    SmsGatewayResource: Object.assign(SmsGatewayResource, SmsGatewayResource),
    SmsLogResource: Object.assign(SmsLogResource, SmsLogResource),
    UserResource: Object.assign(UserResource, UserResource),
}

export default Resources