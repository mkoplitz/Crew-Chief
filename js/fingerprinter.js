window.onload = function() {
  client = new ClientJS();
  console.log(client.getBrowserData());
  console.log(client.getBrowserData().cpu.architecture);
  console.log(client.getBrowserData().os.name);
  console.log(client.getBrowserData().os.version);
  console.log(client.getBrowserData().browser.name);
  console.log(client.getBrowserData().browser.version);
  console.log(client.getBrowserData().device.model);
  console.log(client.getBrowserData().device.vendor);
  console.log(client.getBrowserData().device.type);
}