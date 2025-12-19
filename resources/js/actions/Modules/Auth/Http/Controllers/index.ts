import RegisteredUserController from './RegisteredUserController'
import RegisteredUserWithOTPController from './RegisteredUserWithOTPController'
import VerifyUserWithOTPController from './VerifyUserWithOTPController'
import AuthenticatedSessionController from './AuthenticatedSessionController'
import PasswordResetLinkController from './PasswordResetLinkController'
import NewPasswordController from './NewPasswordController'
import VerifyEmailController from './VerifyEmailController'
import EmailVerificationNotificationController from './EmailVerificationNotificationController'
import MobileVerificationNotificationController from './MobileVerificationNotificationController'

const Controllers = {
    RegisteredUserController: Object.assign(RegisteredUserController, RegisteredUserController),
    RegisteredUserWithOTPController: Object.assign(RegisteredUserWithOTPController, RegisteredUserWithOTPController),
    VerifyUserWithOTPController: Object.assign(VerifyUserWithOTPController, VerifyUserWithOTPController),
    AuthenticatedSessionController: Object.assign(AuthenticatedSessionController, AuthenticatedSessionController),
    PasswordResetLinkController: Object.assign(PasswordResetLinkController, PasswordResetLinkController),
    NewPasswordController: Object.assign(NewPasswordController, NewPasswordController),
    VerifyEmailController: Object.assign(VerifyEmailController, VerifyEmailController),
    EmailVerificationNotificationController: Object.assign(EmailVerificationNotificationController, EmailVerificationNotificationController),
    MobileVerificationNotificationController: Object.assign(MobileVerificationNotificationController, MobileVerificationNotificationController),
}

export default Controllers