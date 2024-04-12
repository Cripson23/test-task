import { createGlobalStyle } from 'styled-components';

const GlobalStyle = createGlobalStyle`
    body {
        font-family: ${props => props.theme.fonts.primary};
        color: ${props => props.theme.colors.dark};
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: ${props => props.theme.fonts.secondary};
    }
`

export default GlobalStyle;