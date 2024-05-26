describe('Home Page UI Test once not logged in', () => {
    it('should display login/register links when user is not logged in', () => {
        cy.visit('/');

        cy.contains('This is the BuyerBridge Assessment Project!');
        cy.contains('Please login / register to begin!');
        cy.get('a').contains('login').should('have.attr', 'href', '/login');
        cy.get('a').contains('register').should('have.attr', 'href', '/register');
    });
});

describe('Home Page UI Test once it is logged in', () => {
    it('should display welcome message and link to create a message when user is logged in', () => {
        cy.intercept('POST', '/api/login', (req) => {
            req.reply({
                statusCode: 200,
                body: {
                    token: 'token'
                }
            });
        });

        cy.visit('/login');

        cy.get('#email').type('jon@example.com');
        cy.get('#password').type('password');
        cy.get('form').submit();

        cy.visit('/');

        cy.contains('Welcome!');
        cy.get('a').contains('Create a new Message Capsule!').should('have.attr', 'href', '/messages');
    });
});
