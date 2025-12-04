import PasswordReset from './PasswordReset'
import Register from './Register'
import EmailVerification from './EmailVerification'

const Auth = {
    PasswordReset: Object.assign(PasswordReset, PasswordReset),
    Register: Object.assign(Register, Register),
    EmailVerification: Object.assign(EmailVerification, EmailVerification),
}

export default Auth