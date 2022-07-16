// import { startStimulusApp } from '@symfony/stimulus-bridge';
//
// Registers Stimulus pages from pages.json and in the pages/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./pages',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party pages here
// app.register('some_controller_name', SomeImportedController);
