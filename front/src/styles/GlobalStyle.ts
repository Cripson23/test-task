import { createGlobalStyle } from 'styled-components';

const GlobalStyle = createGlobalStyle`
    body, html {
        font-family: ${props => props.theme.fonts.primary};
        color: ${props => props.theme.colors.light};
        background: linear-gradient(to right, #e49090, #dd6b6b);
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: ${props => props.theme.fonts.secondary};
    }
`

export default GlobalStyle;