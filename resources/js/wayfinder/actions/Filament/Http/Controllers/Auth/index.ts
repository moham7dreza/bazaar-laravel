import LogoutController from './LogoutController'
import EmailVerificationController from './EmailVerificationController'

const Auth = {
    LogoutController: Object.assign(LogoutController, LogoutController),
    EmailVerificationController: Object.assign(EmailVerificationController, EmailVerificationController),
}

export default Auth