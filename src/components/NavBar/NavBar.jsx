import { Navbar, Nav, Container } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import "./NavBar.css";

const NavBar = () => {
  return (
    <Navbar bg="dark" variant="dark" expand="lg" className="px-3">
      <Container>
        <Navbar.Brand as={Link} to="/">Mi Empresa</Navbar.Brand>
        <Navbar.Toggle aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
          <Nav className="ms-auto">
            <Nav.Link as={Link} to="/nosotros">Nosotros</Nav.Link>
            <Nav.Link as={Link} to="/servicios">Nuestros Servicios</Nav.Link>
            <Nav.Link as={Link} to="/contacto">Contacto</Nav.Link>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
};

export default NavBar;
