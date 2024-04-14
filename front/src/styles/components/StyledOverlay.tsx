import styled, { css } from 'styled-components';

interface AnimatedOverlayProps {
    show: boolean;
}

const Overlay = styled.div.attrs<AnimatedOverlayProps>(() => ({
    'aria-hidden': true
}))`
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0; // Изначально невидим
    visibility: hidden; // Изначально не виден
    transition: opacity 0.3s ease, visibility 0.3s ease;
`;

const AnimatedOverlay = styled(Overlay)<AnimatedOverlayProps>`
    ${({ show }) => show && css`
        opacity: 1;
        visibility: visible;
    `}
`;

export default AnimatedOverlay;